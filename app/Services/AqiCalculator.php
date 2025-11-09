<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class AqiCalculator
{
    /** @var array<string> */
    private array $pollutants = ['pm2_5', 'pm10', 'co', 'no2'];

    /**
     * Compute NowCast AQI using the provided data window.
     * Expects items to have fields: pm2_5, pm10, co, no2.
     */
    public function computeNowCast(Collection $data): array
    {
        $results = [];

        foreach ($this->pollutants as $pollutant) {
            // Reindex to avoid "Undefined array key" when iterating by index
            $values = $data->pluck($pollutant)->filter()->values()->all();

            if (count($values) < 2) {
                $results[$pollutant] = null;
                continue;
            }

            $max = max($values);
            $min = min($values);
            $ratio = $min / max($max, 1e-9);            // guard divide-by-zero
            $weightFactor = max(0.5, min(1.0, $ratio)); // EPA NowCast clamp

            $weightedSum = 0.0;
            $weightTotal = 0.0;
            $count = count($values);    

            foreach ($values as $idx => $val) {
                $weight = pow($weightFactor, $count - $idx - 1);
                $weightedSum += $weight * $val;
                $weightTotal += $weight;
            }

            $nowcastValue = $weightTotal > 0 ? $weightedSum / $weightTotal : null;
            $results[$pollutant] = is_null($nowcastValue)
                ? null
                : $this->convertToAQI($pollutant, (float) $nowcastValue); // already truncated in convertToAQI()
        }

        $results['overall_aqi'] = $this->maxNumeric($results);
        return $results;
    }

    /**
     * Daily bins (Mon–Sun) with NowCast AQI per pollutant.
     */
    public function computeSevenDayBreakdown(Collection $data): Collection
    {
        $results = [];

        $grouped = $data->groupBy(function ($item) {
            return Carbon::parse($item->realtime_stamp, 'UTC')->format('Y-m-d');
        });
        
        foreach ($grouped as $date => $records) {
            $daily = [];

            foreach ($this->pollutants as $pollutant) {
                $values = $records->pluck($pollutant)->filter()->values()->all();

                if (count($values) < 2) {
                    $daily[$pollutant] = null;
                    continue;
                }

                $max = max($values);
                $min = min($values);
                $ratio = $min / max($max, 1e-9);
                $weightFactor = max(0.5, min(1.0, $ratio));

                $weightedSum = 0.0;
                $weightTotal = 0.0;
                $count = count($values);

                foreach ($values as $idx => $val) {
                    $weight = pow($weightFactor, $count - $idx - 1);
                    $weightedSum += $weight * $val;
                    $weightTotal += $weight;
                }

                $nowcastValue = $weightTotal > 0 ? $weightedSum / $weightTotal : null;
                $daily[$pollutant] = is_null($nowcastValue)
                    ? null
                    : $this->convertToAQI($pollutant, (float) $nowcastValue); // truncated in convertToAQI
            }

            $daily['date'] = $date;
            $daily['overall_aqi'] = $this->maxNumeric($daily);
            $results[] = $daily;
        }

        return collect($results)->sortBy('date')->values();
    }

    /**
     * Weekly average + peak decibel (daily bins).
     * Accepts either 'decibel' or 'decibels' columns.
     */
    public function computeWeeklyDecibelStats(Collection $data): Collection
    {
        $grouped = $data->groupBy(function ($item) {
            return Carbon::parse($item->realtime_stamp)->format('Y-m-d');
        });

        $results = [];

        foreach ($grouped as $date => $records) {
            $vals = $records->pluck('decibel')
                ->merge($records->pluck('decibels'))
                ->filter()
                ->values();

            $avg  = $vals->count() ? round($vals->avg(), 2) : null;
            $peak = $vals->count() ? round($vals->max(), 2) : null;

            $results[] = [
                'date'          => $date,
                'avg_decibel'   => $avg,
                'peak_decibel'  => $peak,
            ];
        }

        return collect($results)->sortBy('date')->values();
    }

    private function segmentLabelRolling(string $preset, Carbon $start, Carbon $end): string
    {
        switch ($preset) {
            case '12h':
                return $end->format('h:i A');
            case '24h':
                return $end->format('h:i A');
            case '7d':
            case '30d':
                return $start->format('Y-m-d');
            default:
                // return $start->toDateTimeString() . '–' . $end->toDateTimeString();
                return $start->toDateTimeString();
        }
    }


    /**
     * Segmented individual averages with NowCast AQI per pollutant
     * + average & peak decibels per segment.
     *
     * Presets:
     *  - '12h' => 12 segments, 1-hour intervals (lookback 12h)
     *  - '24h' => 12 segments, 2-hour intervals (lookback 24h)
     *  - '7d'  => 7  segments, 1-day  intervals (lookback 7d)
     *  - '30d' => 30 segments, 1-day  intervals (lookback 30d)
     */
    public function computeSegmentedAverages(
        Collection $data,
        string $preset = '12h',
        ?Carbon $endTime = null,
        string $timestampField = 'realtime_stamp'
    ): Collection {
        
        $end = $endTime ? $endTime->copy() : Carbon::now('UTC');
    
        [$segments, $segmentDuration, $lookback] = $this->presetToSpec($preset);
    
        // Align day-based presets to calendar midnights
        if (in_array($preset, ['7d','30d'], true)) {
            // $end is a moment in UTC; convert to local day boundary if you prefer:
            // If you passed an end-of-day in UTC already, this is fine as-is.
            $end   = $end->copy()->endOfDay();                 // end of that day
            $start = $end->copy()->startOfDay()->subDays($segments - 1);
        } else {
            // Rolling for hour-based presets
            $start = $end->copy()->sub($lookback);
        }
    
        // Sort and window in UTC
        $data = $data->sortBy(fn($item) => Carbon::parse(data_get($item, $timestampField), 'UTC'))->values();
    
        $windowed = $data->filter(function ($item) use ($timestampField, $start, $end) {
            $ts = Carbon::parse(data_get($item, $timestampField), 'UTC');
            return $ts->gte($start) && $ts->lt($end);
        })->values();

        $results = [];
        $segStart = $start->copy();

        for ($i = 0; $i < $segments; $i++) {
            $segEnd = $segStart->copy()->add($segmentDuration);
            if ($segEnd->gt($end)) {
                $segEnd = $end->copy(); // clamp final segment if needed
            }

            // Segment data: [segStart, segEnd)
            $segmentRecords = $windowed->filter(function ($item) use ($timestampField, $segStart, $segEnd) {
                $ts = Carbon::parse(data_get($item, $timestampField), 'UTC');
                return $ts->gte($segStart) && $ts->lt($segEnd);
            })->values();

            // NowCast AQI per pollutant for this segment
            $nowcast = $this->computeNowCast($segmentRecords);

            // Decibel stats (supports 'decibel' or 'decibels')
            $decVals = $segmentRecords->pluck('decibel')
                ->merge($segmentRecords->pluck('decibels'))
                ->filter()
                ->values();

            $avgDecibel  = $decVals->count() ? round($decVals->avg(), 2) : null;
            $peakDecibel = $decVals->count() ? round($decVals->max(), 2) : null;

            $results[] = [
                'start'        => $segStart->toIso8601String(),
                'end'          => $segEnd->toIso8601String(),
                'label'        => $this->segmentLabelRolling($preset, $segStart, $segEnd),
                'pm2_5'        => $nowcast['pm2_5'] ?? null,
                'pm10'         => $nowcast['pm10'] ?? null,
                'co'           => $nowcast['co'] ?? null,
                'no2'          => $nowcast['no2'] ?? null,
                'avg_decibel'  => $avgDecibel,
                'peak_decibel' => $peakDecibel,
                'samples'      => $segmentRecords->count(),
            ];

            $segStart->add($segmentDuration);
            if ($segStart->gte($end)) {
                break; // safety
            }
        }

        return collect($results)->values();
    }


    /**
     * Convert pollutant concentration to AQI (US EPA breakpoints).
     * Returns value truncated to 2 decimal places.
     *
     * Units expected:
     *  - pm2_5: µg/m³
     *  - pm10 : µg/m³
     *  - co   : ppm
     *  - no2  : ppb
     */
    private function convertToAQI(string $pollutant, float $value): ?float
    {
            // 'pm2_5' => [
            //     [0.0,   25.0,   0,   50],   // Good
            //     [25.1,  35.0,  51,  100],   // Fair
            //     [35.1,  45.0, 101,  150],   // Poor
            //     [45.1,  55.0, 151,  200],   // Unhealthy
            //     [55.1,  90.0, 201,  300],   // Severe
            //     [90.1,  INF,  301,  500],   // Emergency
            // ],
        $breakpoints = [
            'pm2_5' => [
                [0.0, 12.0,    0,  50],
                [12.1, 35.4,  51, 100],
                [35.5, 55.4, 101, 150],
                [55.5,150.4, 151, 200],
                [150.5,250.4,201, 300],
                [250.5,500.4,301, 500],
            ],
            'pm10' => [
                [0,    54,     0,  50],
                [55,  154,    51, 100],
                [155, 254,   101, 150],
                [255, 354,   151, 200],
                [355, 424,   201, 300],
                [425, 604,   301, 500],
            ],
            'co' => [
                [0.0,  4.4,    0,  50],
                [4.5,  9.4,   51, 100],
                [9.5, 12.4,  101, 150],
                [12.5,15.4,  151, 200],
                [15.5,30.4,  201, 300],
                [30.5,50.4,  301, 500],
            ],
            'no2' => [
                [0,     53,    0,  50],
                [54,   100,   51, 100],
                [101,  360,  101, 150],
                [361,  649,  151, 200],
                [650, 1249,  201, 300],
                [1250,2049,  301, 500],
            ],
        ];

        if (!isset($breakpoints[$pollutant])) {
            return null;
        }

        foreach ($breakpoints[$pollutant] as [$clo, $chi, $ilo, $ihi]) {
            if ($value >= $clo && $value <= $chi) {
                $aqi = (($ihi - $ilo) / ($chi - $clo)) * ($value - $clo) + $ilo;
                return $this->truncate($aqi, 2); // ← ensure 2-decimal TRUNCATION here
            }
        }

        return null; // out-of-range
    }

    /* ------------------------- Helpers ------------------------- */

    private function maxNumeric(array $arr): ?float
    {
        $nums = array_filter($arr, 'is_numeric');
        return count($nums) ? max($nums) : null;
    }

    /**
     * Truncate (not round) to a fixed number of decimal places.
     */
    private function truncate(float $value, int $precision = 2): float
    {
        $factor = pow(10, $precision);
        // Works for positive AQI; if you ever expect negative, adjust with sign handling
        return floor($value * $factor) / $factor;
    }

    /**
     * Map preset to (segmentCount, segmentDuration, lookbackDuration).
     * @return array{int, CarbonInterval, CarbonInterval}
     */
    private function presetToSpec(string $preset): array
    {
        switch ($preset) {
            case '12h': return [12, CarbonInterval::hours(1), CarbonInterval::hours(12)];
            case '24h': return [12, CarbonInterval::hours(2), CarbonInterval::hours(24)];
            case '7d' : return [7,  CarbonInterval::days(1), CarbonInterval::days(7)];
            case '30d': return [30, CarbonInterval::days(1), CarbonInterval::days(30)];
            default   : return [12, CarbonInterval::hours(1), CarbonInterval::hours(12)];
        }
    }

    private function segmentLabel(string $preset, Carbon $start, Carbon $end): string
    {
        switch ($preset) {
            case '12h':
                return $start->format('h:i A');
            case '24h':
                return $start->format('H:i') . '–' . $end->format('H:i');
            case '7d':
            case '30d':
                return $start->format('Y-m-d');
            default:
                // return $start->toDateTimeString() . '–' . $end->toDateTimeString();
                return $start->toDateTimeString();
        }
    }
    
    public function convertInstantAQIForRow(object|array $row): array
    {
        $get = fn(string $k) => is_array($row) ? ($row[$k] ?? null) : ($row->$k ?? null);

        return [
            'pm2_5' => is_null($get('pm2_5')) ? null : $this->convertToAQI('pm2_5', (float)$get('pm2_5')),
            'pm10'  => is_null($get('pm10'))  ? null : $this->convertToAQI('pm10',  (float)$get('pm10')),
            'co'    => is_null($get('co'))    ? null : $this->convertToAQI('co',    (float)$get('co')),
            'no2'   => is_null($get('no2'))   ? null : $this->convertToAQI('no2',   (float)$get('no2')),
        ];
    }
}

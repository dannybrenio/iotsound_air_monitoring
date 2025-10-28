<?php 

namespace App\Services;

use App\Models\Hardware_data;
use Carbon\Carbon;

class AqiCalculator{

     public function compute()
    {
        // Collect readings from the last 12 hours (144 records)
        // carbon is a library
        $recentData = Hardware_data::where('realtime_stamp', '>=', Carbon::now()->subHours(12))
            ->orderBy('realtime_stamp', 'desc')
            ->get();

        if ($recentData->count() >= 144) {
            return $this->computeNowcast($recentData);
        }

        return $this->computeInstant();
    }

    
     // INSTANT AQI: use latest single reading
     
    public function computeInstant()
    {
        $latest = HardwareData::latest('realtime_stamp')->first();

        if (!$latest) return null;

        $aqi = $this->calculateAqi([
            'pm25' => $latest->pm2_5,
            'pm10' => $latest->pm10,
            'no2'  => $latest->no2,
            'co'   => $latest->co,
        ]);

        return [
            'type' => 'instant',
            'pm25' => $latest->pm25,
            'pm10' => $latest->pm10,
            'no2'  => $latest->no2,
            'co'   => $latest->co,
            'aqi'  => $aqi,
            'time' => $latest->recorded_at,
        ];
    }

      // NOWCAST AQI: weighted 3-hour rolling average
     
    public function computeNowcast($data)
    {
        $pm25Values = $data->pluck('pm2_5')->toArray();
        $pm10Values = $data->pluck('pm10')->toArray();

        $pm25Nowcast = $this->computeNowcastAverage($pm25Values);
        $pm10Nowcast = $this->computeNowcastAverage($pm10Values);

        $latest = $data->first(); // most recent NO2 & CO

        $aqi = $this->calculateAqi([
            'pm25' => $pm25Nowcast,
            'pm10' => $pm10Nowcast,
            'no2'  => $latest->no2,
            'co'   => $latest->co,
        ]);

        return [
            'type'        => 'nowcast',
            'pm25_avg'    => round($pm25Nowcast, 1),
            'pm10_avg'    => round($pm10Nowcast, 1),
            'no2'         => $latest->no2,
            'co'          => $latest->co,
            'aqi'         => round($aqi, 1),
            'records_used'=> $data->count(),
            'period'      => 'last 3 hours',
        ];
    }

    
     // Compute NowCast average using EPA algorithm
     
    private function computeNowcastAverage($values)
    {
        $max = max($values);
        $min = min($values);
        if ($max == 0) return 0;

        $weightFactor = 1 - (($max - $min) / $max);
        $weightFactor = max(0.5, min(0.9, $weightFactor));

        $weightedSum = 0;
        $weightTotal = 0;

        foreach ($values as $index => $val) {
            $weight = pow($weightFactor, $index);
            $weightedSum += $val * $weight;
            $weightTotal += $weight;
        }

        return $weightedSum / $weightTotal;
    }

    /**
     * Universal AQI calculation (same for Instant and NowCast)
     */
    private function calculateAqi($pollutants)
    {
        $aqis = [
            'pm25' => $this->calculateFromBreakpoints($pollutants['pm25'], $this->pm25Breakpoints()),
            'pm10' => $this->calculateFromBreakpoints($pollutants['pm10'], $this->pm10Breakpoints()),
            'no2'  => $this->calculateFromBreakpoints($pollutants['no2'],  $this->no2Breakpoints()),
            'co'   => $this->calculateFromBreakpoints($pollutants['co'],   $this->coBreakpoints()),
        ];

        return max($aqis);
    }

    private function calculateFromBreakpoints($Cp, $breakpoints)
    {
        foreach ($breakpoints as $bp) {
            [$BpLow, $BpHigh, $I_low, $I_high] = $bp;
            if ($Cp >= $BpLow && $Cp <= $BpHigh) {
                return (($I_high - $I_low) / ($BpHigh - $BpLow)) * ($Cp - $BpLow) + $I_low;
            }
        }
        return 500;
    }

    // ----- Breakpoint tables -----

    private function pm25Breakpoints()
    {
        return [
            [0.0, 12.0, 0, 50],
            [12.1, 35.4, 51, 100],
            [35.5, 55.4, 101, 150],
            [55.5, 150.4, 151, 200],
            [150.5, 250.4, 201, 300],
            [250.5, 350.4, 301, 400],
            [350.5, 500.4, 401, 500],
        ],
        'pm10' => [
            [0, 54, 0, 50],
            [55, 154, 51, 100],
            [155, 254, 101, 150],
            [255, 354, 151, 200],
            [355, 424, 201, 300],
            [425, 504, 301, 400],
            [505, 604, 401, 500],
        ],
        'no2' => [
            [0, 53, 0, 50],
            [54, 100, 51, 100],
            [101, 360, 101, 150],
            [361, 649, 151, 200],
            [650, 1249, 201, 300],
            [1250, 1649, 301, 400],
            [1650, 2049, 401, 500],
        ],
        'co' => [
            [0, 4.4, 0, 50],
            [4.5, 9.4, 51, 100],
            [9.5, 12.4, 101, 150],
            [12.5, 15.4, 151, 200],
            [15.5, 30.4, 201, 300],
            [30.5, 40.4, 301, 400],
            [40.5, 50.4, 401, 500],
        ],
    ];

    /**
     * Fetch latest readings and compute AQI
     */
    public function compute()
    {
        // Fetch last 12 readings (1 hour if 5-min intervals)
        $readings = Hardware_data::latest('realtime_stamp')
            ->take(144)
            ->get()
            ->reverse();

        if ($readings->isEmpty()) {
            return null;
        }

        // Extract pollutant values
        $pollutants = ['pm2_5', 'pm10', 'no2', 'co'];
        $aqiValues = [];

        foreach ($pollutants as $pollutant) {
            $values = $readings->pluck($pollutant)->filter()->values()->toArray();

            if (empty($values)) continue;

            // Instant AQI (latest value)
            $instantAqi = $this->calculateAqi($pollutant, end($values));

            // NowCast AQI (weighted average)
            $nowcastValue = $this->computeNowcast($values);
            $nowcastAqi = $this->calculateAqi($pollutant, $nowcastValue);

            $aqiValues[$pollutant] = [
                'instant' => round($instantAqi),
                'nowcast' => round($nowcastAqi),
            ];
        }

        // Determine overall AQI (max pollutant AQI)
        $overallInstant = max(array_column($aqiValues, 'instant'));
        $overallNowcast = max(array_column($aqiValues, 'nowcast'));

        return [
            'pollutants' => $aqiValues,
            'overall' => [
                'instant' => $overallInstant,
                'nowcast' => $overallNowcast,
            ],
        ];
    }

    /**
     * Compute AQI using breakpoints
     */
    private function calculateAqi($pollutant, $concentration)
    {
        foreach ($this->breakpoints[$pollutant] as [$C_low, $C_high, $I_low, $I_high]) {
            if ($concentration >= $C_low && $concentration <= $C_high) {
                return (($I_high - $I_low) / ($C_high - $C_low))
                    * ($concentration - $C_low) + $I_low;
            }
        }
        return null;
    }

    /**
     * Compute NowCast (weighted average)
     * Based on USEPA method adapted for 5-min data
     */
    private function computeNowcast(array $values)
    {
        if (count($values) < 2) {
            return end($values);
        }

        $min = min($values);
        $max = max($values);

        // Weight factor w = min/max (bounded between 0.5–1.0)
        $w = max(0.5, $min / $max);

        $n = count($values);
        $sumWeights = 0;
        $sumWeightedValues = 0;

        // Most recent has highest weight (w^0)
        for ($i = 0; $i < $n; $i++) {
            $weight = pow($w, $n - 1 - $i);
            $sumWeights += $weight;
            $sumWeightedValues += $values[$i] * $weight;
        }

        return $sumWeightedValues / $sumWeights;
    }

}

?>
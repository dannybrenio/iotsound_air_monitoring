<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\AqiCalculator;
use App\Models\Prediction;

class PredictController extends Controller
{
    public function predictLatest(Request $request, AqiCalculator $aqi)
    {
        $baseUrl = rtrim(env('FASTAPI_URL'), '/');
        if (!$baseUrl) {
            return response()->json(["error" => "FASTAPI_URL is not set in .env"], 500);
        }

        // Optional: per-device prediction (HIGHLY recommended if multiple devices exist)
        $hardwareId = $request->query('hardware_id');

        // ✅ Get last 400 sensor rows (approx 12+ hours if 5-min interval)
        $sensorQuery = DB::table('hardware_data')
            ->select(['pm2_5','pm10','co','no2','decibels','realtime_stamp'])
            ->orderBy('realtime_stamp', 'desc')
            ->limit(400);

        if ($hardwareId) {
            $sensorQuery->where('hardware_id', $hardwareId);
        }

        $sensorRows = $sensorQuery
            ->get()
            ->reverse()   // ascending (old -> new)
            ->values();

        if ($sensorRows->count() < 144) {
            return response()->json([
                "error" => "Not enough sensor rows. Need 144 rows (12 hours).",
                "rows_found" => $sensorRows->count(),
                "hardware_id" => $hardwareId,
            ], 400);
        }

        $rows = [];

        // ✅ Build as many VALID rows as possible (do NOT break early)
        foreach ($sensorRows as $r) {

            // skip if any sensor value is null
            if ($r->pm2_5 === null || $r->pm10 === null || $r->co === null || $r->no2 === null || $r->decibels === null) {
                continue;
            }
            
            if ($r->decibels < 30 || $r->decibels > 120) {
                continue;
            }

            $ts = Carbon::parse($r->realtime_stamp)
                ->timezone('Asia/Manila')
                ->format('Y-m-d H:i:s');

            // match weather timestamp to top-of-hour
            $weatherTs = Carbon::parse($ts)->minute(0)->second(0)->format('Y-m-d H:i:s');

            $w = DB::table('weather_data')->where('weather_timestamp', $weatherTs)->first();
            if (!$w) {
                continue;
            }

            // skip if any weather value is null
            if (
                $w->temperature_2m === null || $w->relative_humidity_2m === null || $w->windspeed_10m === null ||
                $w->winddirection_10m === null || $w->pressure_msl === null || $w->precipitation === null || $w->weather_code === null
            ) {
                continue;
            }

            // compute instant AQI per pollutant using your service
            $inst = $aqi->convertInstantAQIForRow((object)[
                "pm2_5" => $r->pm2_5,
                "pm10" => $r->pm10,
                "no2" => $r->no2,
                "co" => $r->co,
                "decibels" => $r->decibels,
                "realtime_stamp" => $r->realtime_stamp,
            ]);

            // overall AQI = max of the instant AQIs
            $overallAqi = max(
                (float)($inst["pm2_5"] ?? 0),
                (float)($inst["pm10"] ?? 0),
                (float)($inst["no2"] ?? 0),
                (float)($inst["co"] ?? 0)
            );

            $rows[] = [
                "pm2_5_raw" => (float)$r->pm2_5,
                "pm10_raw"  => (float)$r->pm10,
                "no2_raw"   => (float)$r->no2,
                "co_raw"    => (float)$r->co,
                "decibel_raw" => (float)$r->decibels,
                "reading_timestamp" => $ts,
                "overall_aqi" => (float)$overallAqi,

                "temperature_2m" => (float)$w->temperature_2m,
                "relative_humidity_2m" => (float)$w->relative_humidity_2m,
                "windspeed_10m" => (float)$w->windspeed_10m,
                "winddirection_10m" => (float)$w->winddirection_10m,
                "pressure_msl" => (float)$w->pressure_msl,
                "precipitation" => (float)$w->precipitation,
                "weather_code" => (int)$w->weather_code,
            ];
        }

        // Need at least 145 (so FastAPI can compute lag144, etc.)
        if (count($rows) < 145) {
            return response()->json([
                "error" => "Not enough complete rows after filtering NULLs.",
                "rows_built" => count($rows),
                "hardware_id" => $hardwareId,
            ], 400);
        }

        // Keep ONLY the most recent 145 valid rows (not the oldest ones)
        $rows = array_slice($rows, -445);

        // ✅ POST to FastAPI
        $resp = Http::timeout(30)->post($baseUrl . "/predict", [
            "rows" => $rows
        ]);

        if (!$resp->successful()) {
            return response()->json([
                "error" => "FastAPI prediction failed",
                "status" => $resp->status(),
                "body" => $resp->json() ?? $resp->body(),
                "hardware_id" => $hardwareId,
            ], 500);
        }

        // Keep original response
        $payload = $resp->json();

        // Extract values (supports multiple possible key names)
        $aqiPred = $payload['aqi_next_hour_avg']
            ?? $payload['aqi_next_hour_avg_1h']
            ?? $payload['aqi_pred']
            ?? null;

        $noisePred = $payload['noise_next_hour_avg']
            ?? $payload['noise_next_hour_avg_1h']
            ?? $payload['noise_pred']
            ?? null;

        // ✅ Save timestamp as the hour being predicted: last sent sensor timestamp + 1 hour
        $lastSentTs = $rows[count($rows) - 1]['reading_timestamp'] ?? null;

        $forecastTs = $lastSentTs
            ? Carbon::parse($lastSentTs, 'Asia/Manila')->addHour()
            : Carbon::now('Asia/Manila')->addHour();

        // ✅ Persist (avoid duplicates per hour)
        try {
            Prediction::updateOrCreate(
                [
                    'hardware_id' => $hardwareId,
                    'timestamp'   => $forecastTs->format('Y-m-d H:i:s'),
                ],
                [
                    'aqi_next_hour_avg'   => is_numeric($aqiPred) ? (float)$aqiPred : null,
                    'noise_next_hour_avg' => is_numeric($noisePred) ? (float)$noisePred : null,
                ]
            );
        } catch (\Throwable $e) {
            Log::warning('[Predict] Failed to save prediction', [
                'message' => $e->getMessage(),
                'hardware_id' => $hardwareId,
                'forecast_ts' => $forecastTs->toIso8601String(),
            ]);
        }

        return response()->json($payload);
    }
    
    private function fetchActualRows($start, $end, $hid)
    {
        $q = DB::table('hardware_data')
            ->select(['pm2_5','pm10','co','no2','decibels','realtime_stamp'])
            ->whereBetween('realtime_stamp', [
                $start->format('Y-m-d H:i:s'),
                $end->format('Y-m-d H:i:s')
            ])
            ->orderBy('realtime_stamp', 'asc');
    
        if (!empty($hid)) {
            $q->where('hardware_id', $hid);
        }
    
        return $q->get();
    }

    /**
     * Compare predictions vs actual AQI (computed from hardware_data) for the predicted hour.
     *
     * Route example:
     *   /predictions/compare?hardware_id=1&limit=20
     */
public function compare(Request $request, AqiCalculator $aqi)
{
    $appTz = config('app.timezone', 'Asia/Manila');
    $hardwareId = $request->query('hardware_id'); // optiona
    $limit = (int) $request->query('limit', 20);
    if ($limit <= 0) $limit = 20;

    // Pull recent predictions, then average them per hour (same forecast hour)
    $predAgg = DB::table('predictions')
        ->selectRaw("
            COALESCE(hardware_id, ?) as hardware_id_resolved,
            DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00') as hour_local,
            AVG(aqi_next_hour_avg) as predicted_aqi_hour_avg,
            MIN(aqi_next_hour_avg) as predicted_aqi_min,
            MAX(aqi_next_hour_avg) as predicted_aqi_max,
            COUNT(*) as prediction_rows
        ", [$hardwareId])
        ->whereNotNull('aqi_next_hour_avg')
        ->when(!empty($hardwareId), function ($q) use ($hardwareId) {
            // include rows where hardware_id matches OR is NULL (older data)
            $q->where(function ($qq) use ($hardwareId) {
                $qq->where('hardware_id', $hardwareId)->orWhereNull('hardware_id');
            });
        })
        ->groupBy('hardware_id_resolved', 'hour_local')
        ->orderByDesc('hour_local')
        ->limit($limit * 3) // pull extra so we can safely unique per hour below
        ->get();

    // Ensure we return at most $limit unique hours
    $predAgg = $predAgg->unique('hour_local')->take($limit)->values();

    $out = [];

    foreach ($predAgg as $row) {
        $hid = $row->hardware_id_resolved ?: $hardwareId;

        $hourTs = Carbon::parse($row->hour_local, $appTz);

        // ✅ Strict hour window (this IS the forecast hour)
        $strictStart = $hourTs->copy()->startOfHour();
        $strictEnd   = $hourTs->copy()->endOfHour();

        $start = $strictStart->copy();
        $end   = $strictEnd->copy();

        $actualRows = $this->fetchActualRows($start, $end, $hid);

        // ✅ Optional fallback: previous hour if strict has no data yet
        $fallbackUsed = false;
        if ($actualRows->count() === 0) {
            $fallbackUsed = true;
            $start = $hourTs->copy()->subHour()->startOfHour();
            $end   = $hourTs->copy()->subHour()->endOfHour();
            $actualRows = $this->fetchActualRows($start, $end, $hid);
        }

        // Compute "actual AQI hour avg" from hardware_data for that hour:
        $overallAqis = [];

        foreach ($actualRows as $r) {
            if ($r->pm2_5 === null || $r->pm10 === null || $r->co === null || $r->no2 === null) {
                continue;
            }

            $inst = $aqi->convertInstantAQIForRow((object)[
                "pm2_5" => $r->pm2_5,
                "pm10" => $r->pm10,
                "no2" => $r->no2,
                "co" => $r->co,
                "decibels" => $r->decibels,
                "realtime_stamp" => $r->realtime_stamp,
            ]);

            $overall = max(
                (float)($inst["pm2_5"] ?? 0),
                (float)($inst["pm10"] ?? 0),
                (float)($inst["no2"] ?? 0),
                (float)($inst["co"] ?? 0)
            );

            $overallAqis[] = $overall;
        }

        $actualAqiAvg = count($overallAqis) > 0
            ? round(array_sum($overallAqis) / count($overallAqis), 2)
            : null;

        // Predicted AQI per hour (aggregated)
        $predAqiAvg = is_null($row->predicted_aqi_hour_avg) ? null : round((float)$row->predicted_aqi_hour_avg, 2);

        $diff = (!is_null($predAqiAvg) && !is_null($actualAqiAvg))
            ? round($predAqiAvg - $actualAqiAvg, 2)
            : null;

        $absDiff = is_null($diff) ? null : round(abs($diff), 2);

        $pctError = (!is_null($absDiff) && !is_null($actualAqiAvg) && (float)$actualAqiAvg != 0.0)
            ? round(($absDiff / (float)$actualAqiAvg) * 100, 2)
            : null;

        $out[] = [
            'hardware_id' => $hid,

            // This is the hour bucket we aggregated predictions into
            'forecast_hour_local' => $hourTs->toDateTimeString(),

            'predicted_aqi_hour_avg' => $predAqiAvg,
            'predicted_aqi_min'      => is_null($row->predicted_aqi_min) ? null : round((float)$row->predicted_aqi_min, 2),
            'predicted_aqi_max'      => is_null($row->predicted_aqi_max) ? null : round((float)$row->predicted_aqi_max, 2),
            'prediction_rows_averaged' => (int)$row->prediction_rows,

            'actual_aqi_hour_avg' => $actualAqiAvg,

            'difference_pred_minus_actual' => $diff,
            'absolute_error'               => $absDiff,
            'percent_error'                => $pctError,

            'actual_points_used' => count($overallAqis),

            'strict_window' => [
                'start_local' => $strictStart->toDateTimeString(),
                'end_local'   => $strictEnd->toDateTimeString(),
            ],
            'fallback_used' => $fallbackUsed,
            'actual_window_used' => [
                'start_local' => $start->toDateTimeString(),
                'end_local'   => $end->toDateTimeString(),
            ],
        ];
    }

    return response()->json([
        'timezone' => $appTz,
        'hardware_id' => $hardwareId,
        'limit' => $limit,
        'count' => count($out),
        'data' => $out,
    ], 200, [], JSON_PRETTY_PRINT);
}


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hardware_data;
use Illuminate\Http\Request;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SensorDataController extends Controller
{
    /**
     * API version of the dashboard aggregates.
     * Mirrors DashboardController::index() (local-only time handling).
     */
public function index(Request $request)
{
    $aqiService = new AqiCalculator();

    // Local anchors (matching your dashboard)
    $appTz    = config('app.timezone', 'Asia/Manila');
    $nowLocal = Carbon::now($appTz)->floorMinute();
    $endLocalDay = $nowLocal->copy()->subDay()->endOfDay();
    $since30dLocal = $nowLocal->copy()->subDays(30);

    // Pull superset once
    $rangeData = Hardware_data::select([
            'realtime_stamp', 'pm2_5', 'pm10', 'no2', 'co', 'decibels',
        ])
        ->where('realtime_stamp', '>=', $since30dLocal)
        ->where('realtime_stamp', '<',  $nowLocal)
        ->orderBy('realtime_stamp')
        ->get();

    // Segments (unchanged)
    $seg7d = $aqiService->computeSegmentedAverages($rangeData, '7d', $endLocalDay);

    // --- NEW: return flat list if requested ---
    if ($request->boolean('flat')) {
        // Normalize each bucket to the keys your Flutter code checks
        $flat = collect($seg7d)->map(function ($row) use ($appTz) {
            // $row may be array or object; coerce to array safely
            $r = is_array($row) ? $row : (is_object($row) ? (array) $row : []);
            $start = isset($r['start']) ? Carbon::parse($r['start'], $appTz) : null;
            $end   = isset($r['end'])   ? Carbon::parse($r['end'],   $appTz) : null;

            $pm25 = isset($r['pm2_5']) ? (float) $r['pm2_5'] : (isset($r['pm25']) ? (float) $r['pm25'] : 0.0);
            $pm10 = isset($r['pm10']) ? (float) $r['pm10'] : 0.0;
            $co   = isset($r['co'])   ? (float) $r['co']   : 0.0;
            $no2  = isset($r['no2'])  ? (float) $r['no2']  : 0.0;

            $avgDb = $r['avg_decibel'] ?? $r['avgDecibel'] ?? null;
            $avgDb = is_null($avgDb) ? null : (float) $avgDb;

            $peakDb = $r['peak_decibel'] ?? $r['peakDecibel'] ?? null;
            $peakDb = is_null($peakDb) ? null : (float) $peakDb;

            $label = $r['label'] ?? ($start ? $start->toDateString() : null);

            return [
                // keep the originals
                'start'        => $start ? $start->toIso8601String() : null,
                'end'          => $end   ? $end->toIso8601String()   : null,
                'label'        => $label,

                // numeric metrics
                'pm2_5'        => $pm25,          // snake_case
                'pm25'         => $pm25,          // camel-ish (your Flutter tries both)
                'pm10'         => $pm10,
                'co'           => $co,
                'no2'          => $no2,

                // decibels (provide all variants your app probes)
                'avg_decibel'  => $avgDb,
                'avgDecibel'   => $avgDb,
                'decibels'     => $avgDb,         // some UI treats this as “latest/avg”

                // extras if present
                'peak_decibel' => $peakDb,
                'samples'      => isset($r['samples']) ? (int) $r['samples'] : null,

                // optional: friendly date for labelDate usage
                'labelDate'    => $start ? $start->toDateString() : null,
            ];
        })->values();

        // Return a bare list (no {data, meta}) to match the client expectation
        return response()->json($flat, 200, [], JSON_UNESCAPED_SLASHES);
    }

    // Default: keep your old { data, meta } payload
    return response()->json([
        'data' => $seg7d,
        'meta' => [
            'tz'          => $appTz,
            'start_local' => $endLocalDay->copy()->subDays(7)->startOfDay()->toIso8601String(),
            'end_local'   => $endLocalDay->toIso8601String(),
            // keep these for other consumers (you can duplicate local if all-local)
            'start_utc'   => $endLocalDay->copy()->subDays(7)->startOfDay()->toIso8601String(),
            'end_utc'     => $endLocalDay->toIso8601String(),
        ],
    ], 200, [], JSON_UNESCAPED_SLASHES);
}


    /**
     * Latest snapshot endpoint (also in LOCAL, consistent with dashboard).
     */
   public function latest()
    {
        $aqiService = new AqiCalculator();

        $appTz    = config('app.timezone', 'Asia/Manila');
        $nowLocal = Carbon::now($appTz)->floorMinute();

        // Superset (last 7 days) in LOCAL
        $sinceLocal = $nowLocal->copy()->subDays(7);

        $rangeData = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
            ->where('realtime_stamp', '>=', $sinceLocal)
            ->where('realtime_stamp', '<',  $nowLocal)
            ->orderBy('realtime_stamp')
            ->get();

        // Today’s LOCAL day window
        $todayStartLocal = $nowLocal->copy()->startOfDay();
        $todayEndLocal   = $nowLocal->copy()->endOfDay();

        $todayData = $rangeData->filter(function ($row) use ($todayStartLocal, $todayEndLocal, $appTz) {
            $ts = Carbon::parse($row->realtime_stamp, $appTz);
            return $ts->between($todayStartLocal, $todayEndLocal);
        })->values();

        // Compute today's nowcast + overall AQI
        $latestNowcast = $aqiService->computeNowCast($todayData);
        $latestAqi     = $latestNowcast['overall_aqi'] ?? null;

        Log::info("LATEST AQI TO MOBILE (local):", [ "aqi" => $latestAqi ]);

        // Latest decibel from the most recent reading today (LOCAL ordering)
        $latestRecord  = $todayData->sortByDesc(function ($row) use ($appTz) {
            return Carbon::parse($row->realtime_stamp, $appTz);
        })->first();
        $latestDecibel = $latestRecord ? ($latestRecord->decibels ?? null) : null;

        return response()->json([
            'latest_aqi'     => $latestAqi,
            'latest_decibel' => $latestDecibel,
            'computed_at'    => $nowLocal->toIso8601String(), // Local timestamp for clients
            'meta'           => [
                'tz'           => $appTz,
                'today_start'  => $todayStartLocal->toIso8601String(),
                'today_end'    => $todayEndLocal->toIso8601String(),
            ],
        ]);
    }

}

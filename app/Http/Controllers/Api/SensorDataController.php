<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FCMv1Controller;
use App\Models\Hardware_data;
use Illuminate\Http\Request;
use App\Services\AqiCalculator;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    public function index()
    {
        // return latest N readings (adjust fields to your table)
        // $readings = Hardware_data::orderBy('created_at', 'desc')
        //     ->limit(50)
        //     ->get(['hardware_id','pm2_5','pm10','co','no2','decibels','realtime_stamp']);

        // return response()->json([
        //     'data' => $readings->reverse()->values(), // oldest→newest for charts
        // ]);
        $aqiService = new AqiCalculator();

        $now = Carbon::now('UTC')->floorMinute();

        // Give yourself a tiny cushion so the first bin isn’t starved by boundary truncation
        $since = $now->copy()->subDays(7);

        // Right-open SQL range: [since, now)
        $rangeData = Hardware_data::select([
                'realtime_stamp','pm2_5','pm10','no2','co','decibels'
            ])
            ->where('realtime_stamp', '>=', $since)
            ->where('realtime_stamp', '<',  $now)
            ->orderBy('realtime_stamp')
            ->get();

        $seg7d = $aqiService->computeSegmentedAverages($rangeData, '7d', $now);
        return response()->json(['data' => $seg7d]);

    }

    // Fetch latest aqi
    public function latest()
    {
        $aqiService = new AqiCalculator();

        // Time anchors
        $appTz  = config('app.timezone', 'Asia/Manila');
        $nowUtc = Carbon::now('UTC')->floorMinute();

        // Fetch a superset of recent data (last 30 days)
        $since30dUtc = $nowUtc->copy()->subDays(30);
        $rangeData = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
            ->where('realtime_stamp', '>=', $since30dUtc)
            ->where('realtime_stamp', '<', $nowUtc)
            ->orderBy('realtime_stamp')
            ->get();

        // Today’s range (using local timezone but comparing in UTC)
        $todayStartUtc = $nowUtc->copy()->setTimezone($appTz)->startOfDay()->setTimezone('UTC');
        $todayEndUtc   = $nowUtc->copy()->setTimezone($appTz)->endOfDay()->setTimezone('UTC');

        $todayData = $rangeData->filter(function ($row) use ($todayStartUtc, $todayEndUtc) {
            $ts = Carbon::parse($row->realtime_stamp, 'UTC');
            return $ts->gte($todayStartUtc) && $ts->lte($todayEndUtc);
        })->values();

        // Compute nowcast and extract the latest AQI
        $latestNowcast = $aqiService->computeNowCast($todayData);
        $latestAqi     = $latestNowcast['overall_aqi'] ?? null;

        return response()->json([
            'latest_aqi' => $latestAqi,
            'computed_at' => $nowUtc->toIso8601String(),
        ]);
    }
}

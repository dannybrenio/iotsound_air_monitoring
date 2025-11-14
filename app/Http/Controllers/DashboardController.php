<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use App\Events\ReadingReceived;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $aqiService = new AqiCalculator();

        // ✅ Keep everything in local timezone only
        $appTz   = config('app.timezone', 'Asia/Manila');
        $nowLocal = Carbon::now($appTz)->floorMinute();

        // For stable 7-day series: end at yesterday 23:59:59 (LOCAL)
        $endLocalDay = $nowLocal->copy()->subDay()->endOfDay();

        // Fetch a superset for all calcs: [now-30d, now)
        $since30dLocal = $nowLocal->copy()->subDays(30);

        $rangeData = Hardware_data::select([
                'realtime_stamp',
                'pm2_5',
                'pm10',
                'no2',
                'co',
                'decibels',
            ])
            ->where('realtime_stamp', '>=', $since30dLocal)
            ->where('realtime_stamp', '<', $nowLocal)
            ->orderBy('realtime_stamp')
            ->get();

        // --- Rolling 12h window for "latest" nowcast
        $winStartLocal = $nowLocal->copy()->subHours(12);
        $windowData  = $rangeData->filter(function ($row) use ($winStartLocal, $nowLocal, $appTz) {
            $ts = Carbon::parse($row->realtime_stamp, $appTz);
            return $ts->gte($winStartLocal) && $ts->lte($nowLocal);
        })->values();

        $latestRecord  = $windowData->sortByDesc(function ($row) use ($appTz) {
            return Carbon::parse($row->realtime_stamp, $appTz);
        })->first();

        $latestNowcast = $aqiService->computeNowCast($windowData);
        $latestAqi     = $latestNowcast['overall_aqi'] ?? null;
        $latestDecibel = $latestRecord->decibels ?? null;

        // Display in local time
        $latestDateTime = $latestRecord
            ? Carbon::parse($latestRecord->realtime_stamp, $appTz)->toDateTimeString()
            : null;

        // --- Today's data (LOCAL)
        $todayStartLocal = $nowLocal->copy()->startOfDay();
        $todayEndLocal   = $nowLocal->copy()->endOfDay();

        $todayData = $rangeData->filter(function ($row) use ($todayStartLocal, $todayEndLocal, $appTz) {
            $ts = Carbon::parse($row->realtime_stamp, $appTz);
            return $ts->gte($todayStartLocal) && $ts->lte($todayEndLocal);
        })->values();

        $avgDecibelToday = optional($todayData->pluck('decibels')->filter())->avg();
        $avgDecibelToday = is_null($avgDecibelToday) ? null : round($avgDecibelToday, 2);
        $peakDecibel     = $todayData->pluck('decibels')->filter()->max() ?? null;

        // --- Segmented outputs (pass local anchors)
        $seg12h = $aqiService->computeSegmentedAverages($rangeData, '12h', $nowLocal);
        $seg24h = $aqiService->computeSegmentedAverages($rangeData, '24h', $nowLocal);
        $seg7d  = $aqiService->computeSegmentedAverages($rangeData, '7d',  $endLocalDay);
        $seg30d = $aqiService->computeSegmentedAverages($rangeData, '30d', $nowLocal);

        return view('front.dashboard', [
            'latest_aqi'      => $latestAqi,
            'latest_nowcast'  => $latestNowcast,
            'latest_decibel'  => $latestDecibel,
            'peak_decibel'    => $peakDecibel,
            'latest_datetime' => $latestDateTime,
            'avgDecibelToday' => $avgDecibelToday,
            'seg12h'          => $seg12h,
            'seg24h'          => $seg24h,
            'seg7d'           => $seg7d,
            'seg30d'          => $seg30d,
        ]);
    }

    public function sendReading(Request $request)
    {
        ReadingReceived::dispatch($request);
    }

    public function receiveSensorStatus(Request $request)
    {
        // Placeholder
    }
}

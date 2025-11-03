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
    
        // Time anchors
        $appTz  = config('app.timezone', 'Asia/Manila');
        $nowUtc = Carbon::now('UTC')->floorMinute();
    
        // For stable 7-day series: end at yesterday 23:59:59 (local), then to UTC
        $endLocalDay = $nowUtc->copy()->setTimezone($appTz)->subDay()->endOfDay();
        $endUtc      = $endLocalDay->copy()->setTimezone('UTC');
    
        // Fetch a superset for all calcs: [now-30d, now)
        $since30dUtc = $nowUtc->copy()->subDays(30);
        $rangeData = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
            ->where('realtime_stamp', '>=', $since30dUtc)
            ->where('realtime_stamp', '<',  $nowUtc)  // right-open [start, end)
            ->orderBy('realtime_stamp')
            ->get();
    
        // --- Rolling 12h window for "latest" nowcast (this fixes the mismatch)
        $winStartUtc = $nowUtc->copy()->subHours(12);
        $windowData = $rangeData->filter(function ($row) use ($winStartUtc, $nowUtc) {
            $ts = Carbon::parse($row->realtime_stamp, 'UTC');
            return $ts->gte($winStartUtc) && $ts->lte($nowUtc);
        })->values();
    
        $latestRecord   = $windowData->sortByDesc('realtime_stamp')->first();
        $latestNowcast  = $aqiService->computeNowCast($windowData);
        $latestAqi      = $latestNowcast['overall_aqi'] ?? null;
        $latestDecibel  = $latestRecord->decibels ?? null;
        $latestDateTime = $latestRecord->realtime_stamp ?? null;
    
        // --- Today's data only for decibel averages (still fine to keep by local day)
        $todayStartUtc = $nowUtc->copy()->setTimezone($appTz)->startOfDay()->setTimezone('UTC');
        $todayEndUtc   = $nowUtc->copy()->setTimezone($appTz)->endOfDay()->setTimezone('UTC');
        $todayData = $rangeData->filter(function ($row) use ($todayStartUtc, $todayEndUtc) {
            $ts = Carbon::parse($row->realtime_stamp, 'UTC');
            return $ts->gte($todayStartUtc) && $ts->lte($todayEndUtc);
        })->values();
    
        $avgDecibelToday = optional($todayData->pluck('decibels')->filter())->avg();
        $avgDecibelToday = is_null($avgDecibelToday) ? null : round($avgDecibelToday, 2);
        $peakDecibel     = $todayData->pluck('decibels')->filter()->max() ?? null;
    
        // --- Segmented outputs (unchanged)
        $seg12h = $aqiService->computeSegmentedAverages($rangeData, '12h', $nowUtc);  // rolling
        $seg24h = $aqiService->computeSegmentedAverages($rangeData, '24h', $nowUtc);  // rolling
        $seg7d  = $aqiService->computeSegmentedAverages($rangeData, '7d',  $endUtc);  // stable (ends yesterday)
        $seg30d = $aqiService->computeSegmentedAverages($rangeData, '30d', $nowUtc);  // rolling
    
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

    public function sendReading(Request $request){
        ReadingReceived::dispatch($request);
    }

    public function receiveSensorStatus(Request $request){
        // Placeholder
    }
}

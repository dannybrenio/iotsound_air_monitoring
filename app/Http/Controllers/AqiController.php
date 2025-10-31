<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Hardware_data;
use App\Services\AqiCalculator;
use Carbon\Carbon;

class AqiController extends Controller
{
    public function index()
    {
        $aqiService = new AqiCalculator();
        
        $today = Carbon::today();
        $now   = Carbon::now();

        // Pull enough data to cover all presets (max is 30 days)
        $since30d   = $now->copy()->subDays(30);
        $rangeData  = Hardware_data::where('realtime_stamp', '>=', $since30d)->orderBy('realtime_stamp')->get();

        // --- Existing: today's data ---
        $todayData = Hardware_data::whereDate('realtime_stamp', $today)->get();

        // --- Existing: this week's data (Mon–Sun) ---
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd   = $today->copy()->endOfWeek();
        $weekData  = Hardware_data::whereBetween('realtime_stamp', [$weekStart, $weekEnd])->get();

        // --- Existing "today" summary (kept) ---
        $latestRecord   = $todayData->sortByDesc('realtime_stamp')->first();
        $latestNowcast  = $aqiService->computeNowCast($todayData);
        $latestAqi      = $latestNowcast['overall_aqi'] ?? null;

        // Handle possible field name variations: 'decibel' vs 'decibels'
        $latestDecibel  = $latestRecord ? ($latestRecord->decibel ?? $latestRecord->decibels ?? null) : null;
        $peakDecibel    = max(
            $todayData->pluck('decibel')->filter()->all() + $todayData->pluck('decibels')->filter()->all() ?: [0]
        ) ?: null;

        $latestDateTime = $latestRecord->realtime_stamp ?? null;

        // --- Existing weekly breakdowns (kept) ---
        $weeklyNowcast   = $aqiService->computeSevenDayBreakdown($weekData);
        $weeklyDecibels  = $aqiService->computeWeeklyDecibelStats($weekData);

        // --- NEW: Segmented outputs you requested ---
        // 12 hr → 12 segments, 1-hour intervals
        $seg12h  = $aqiService->computeSegmentedAverages($rangeData, '12h', $now);

        // 24 hr → 12 segments, 2-hour intervals
        $seg24h  = $aqiService->computeSegmentedAverages($rangeData, '24h', $now);

        // 7 days → 7 segments, 1-day intervals
        $seg7d   = $aqiService->computeSegmentedAverages($rangeData, '7d', $now);

        // 30 days → 30 segments, 1-day intervals
        $seg30d  = $aqiService->computeSegmentedAverages($rangeData, '30d', $now);
        
        return view('test', [
            // existing
            'latest_aqi'       => $latestAqi,
            'latest_nowcast'   => $latestNowcast,
            'latest_decibel'   => $latestDecibel,
            'peak_decibel'     => $peakDecibel,
            'latest_datetime'  => $latestDateTime,
            'weekly_nowcast'   => $weeklyNowcast,
            'weekly_decibels'  => $weeklyDecibels,

            // new segmented data for console logging
            'seg12h' => $seg12h,
            'seg24h' => $seg24h,
            'seg7d'  => $seg7d,
            'seg30d' => $seg30d,
        ]);
    }
}

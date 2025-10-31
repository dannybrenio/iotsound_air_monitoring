<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use App\Models\HardwareDataController;
use App\Events\ReadingReceived;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $aqiService = new AqiCalculator();

        // Use consistent "now" so all calculations align to the same instant
        $now    = Carbon::now()->startOfMinute();
        $today  = $now->copy()->startOfDay();
        $since30d = $now->copy()->subDays(30);

        // ✅ Single DB query for the whole range (select only fields you use)
        $rangeData = Hardware_data::select([
                'realtime_stamp', 'pm2_5', 'pm10', 'no2', 'co', 'decibels'
            ])
            ->whereBetween('realtime_stamp', [$since30d, $now])
            ->orderBy('realtime_stamp')     // stable ordering for downstream calcs
            ->get();

        // --- Derive today's data in memory (no extra SQL)
        $todayData = $rangeData->whereBetween('realtime_stamp', [
            $today, $today->copy()->endOfDay()
        ])->values();

        // ✅ Average decibel for current day (rounded 2 dp)
        $avgDecibelToday = $todayData->pluck('decibel')
                                ->merge($todayData->pluck('decibels'))
                                ->filter()
                                ->avg();
        $avgDecibelToday = is_null($avgDecibelToday) ? null : round($avgDecibelToday, 2);

        // --- Existing "today" summary (unchanged logic, just using $todayData)
        $latestRecord   = $todayData->sortByDesc('realtime_stamp')->first();
        $latestNowcast  = $aqiService->computeNowCast($todayData);
        $latestAqi      = $latestNowcast['overall_aqi'] ?? null;

        // Handle possible field name variations: 'decibel' vs 'decibels'
        $latestDecibel  = $latestRecord ? ($latestRecord->decibel ?? $latestRecord->decibels ?? null) : null;

        // Merge both fields, filter nulls/zeros, compute peak
        $peakDecibel = collect([
                ...$todayData->pluck('decibel')->filter()->all(),
                ...$todayData->pluck('decibels')->filter()->all(),
            ])->max() ?? null;

        $latestDateTime = $latestRecord->realtime_stamp ?? null;

        // --- Segmented outputs (unchanged)
        $seg12h = $aqiService->computeSegmentedAverages($rangeData, '12h', $now);
        $seg24h = $aqiService->computeSegmentedAverages($rangeData, '24h', $now);
        $seg7d  = $aqiService->computeSegmentedAverages($rangeData, '7d',  $now);
        $seg30d = $aqiService->computeSegmentedAverages($rangeData, '30d', $now);

        return view('front.dashboard', [
            'latest_aqi'      => $latestAqi,
            'latest_nowcast'  => $latestNowcast,
            'latest_decibel'  => $latestDecibel,
            'peak_decibel'    => $peakDecibel,
            'latest_datetime' => $latestDateTime,
            'avgDecibelToday' => $avgDecibelToday,
            'seg12h' => $seg12h,
            'seg24h' => $seg24h,
            'seg7d'  => $seg7d,
            'seg30d' => $seg30d,
        ]);
    }

    public function sendReading(Request $request){
        ReadingReceived::dispatch($request);
        
        // return response()->json(['ok' => true]);
    }

    public function receiveSensorStatus(Request $request){
        // Log::info('POST /api/readings payload', ['body' => $request->all()]);
        
        // $data = $request->validate([
        //     'deviceId'     => 'required|string|max:64',
        //     'pm2_5'        => 'nullable|numeric',
        //     'pm10'         => 'nullable|numeric',
        //     'temp_c'       => 'nullable|numeric',
        //     'rh'           => 'nullable|numeric',
        //     'noise_leq_db' => 'nullable|numeric',
        // ]);
    }
}

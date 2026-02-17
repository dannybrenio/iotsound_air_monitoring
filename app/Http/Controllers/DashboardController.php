<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use App\Models\Hardware;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use App\Events\ReadingReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $aqiService = new AqiCalculator();

        // -------------------------------
        // Cache: hardware list (stable)
        // -------------------------------
        $hardwares = Cache::remember('dashboard:hardwares', now()->addMinutes(10), function () {
            return Hardware::select('hardware_id', 'location_name', 'public_hash', 'longitude', 'latitude')->get();
        });

        $selectedHash = $request->query('hardware');

        $selectedHardware = Hardware::where('public_hash', $selectedHash)->first()
            ?? $hardwares->first();

        $selectedHardwareId = $selectedHardware?->hardware_id;

        $selectedLat = $selectedHardware?->latitude ?? 14.6458;
        $selectedLon = $selectedHardware?->longitude ?? 120.9865;

        $appTz         = config('app.timezone', 'Asia/Manila');
        $nowLocal      = Carbon::now($appTz);
        $endLocalDay   = $nowLocal->copy()->subDay()->endOfDay();
        $since30dLocal = $nowLocal->copy()->subDays(30);

        /**
         * ---------------------------------------------------
         * 1) Get latest timestamp (cheap MAX query)
         *    Optional: micro-cache it for a few seconds
         * ---------------------------------------------------
         */
        $latestTimestamp = Cache::remember(
            'dashboard:latest_ts:' . ($selectedHardwareId ?? 'none'),
            now()->addSeconds(10),
            function () use ($selectedHardwareId, $since30dLocal, $nowLocal) {
                return Hardware_data::when($selectedHardwareId, fn ($q) => $q->where('hardware_id', $selectedHardwareId))
                    ->where('realtime_stamp', '>=', $since30dLocal)
                    ->where('realtime_stamp', '<=', $nowLocal)
                    ->max('realtime_stamp'); // returns string/datetime or null
            }
        );

        // If there's no data yet, keep key stable (prevents "dashboard_none_" keys changing)
        $latestTimestampKeyPart = $latestTimestamp ? Carbon::parse($latestTimestamp)->format('YmdHis') : 'no_data';

        /**
         * ---------------------------------------------------
         * 2) Cache computed payload keyed by latest timestamp
         *    - New row => max timestamp changes => new key
         *    - TTL can be longer (old keys will expire)
         * ---------------------------------------------------
         */
        $cacheKey = "dashboard:data:" . ($selectedHardwareId ?? 'none') . ":" . $latestTimestampKeyPart;

        $computed = Cache::remember($cacheKey, now()->addMinutes(10), function () use (
            $aqiService,
            $selectedHardwareId,
            $since30dLocal,
            $nowLocal,
            $endLocalDay,
            $appTz
        ) {
            $rangeData = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
                ->when($selectedHardwareId, fn($q) => $q->where('hardware_id', $selectedHardwareId))
                ->where('realtime_stamp', '>=', $since30dLocal)
                ->where('realtime_stamp', '<=', $nowLocal)
                ->orderBy('realtime_stamp')
                ->get();

            // --- Rolling 12h window
            $winStartLocal = $nowLocal->copy()->subHours(12);

            $windowData = $rangeData->filter(function ($row) use ($winStartLocal, $nowLocal, $appTz) {
                $ts = Carbon::parse($row->realtime_stamp, $appTz);
                return $ts->gte($winStartLocal) && $ts->lte($nowLocal);
            })->values();

            $latestRecord = $windowData->sortByDesc(fn($row) => Carbon::parse($row->realtime_stamp, $appTz))->first();

            $latestVals = $latestRecord ? [
                'pm2_5' => $latestRecord->pm2_5,
                'pm10'  => $latestRecord->pm10,
                'co'    => $latestRecord->co,
                'no2'   => $latestRecord->no2,
            ] : null;

            $latestNowcast = $aqiService->computeNowCast($windowData);
            $latestAqi     = $latestNowcast['overall_aqi'] ?? null;
            $latestDecibel = $latestRecord->decibels ?? null;

            $latestDateTime = $latestRecord
                ? Carbon::parse($latestRecord->realtime_stamp, $appTz)->toDateTimeString()
                : null;

            // --- Today
            $todayStartLocal = $nowLocal->copy()->startOfDay();
            $todayEndLocal   = $nowLocal->copy()->endOfDay();

            $todayData = $rangeData->filter(function ($row) use ($todayStartLocal, $todayEndLocal, $appTz) {
                $ts = Carbon::parse($row->realtime_stamp, $appTz);
                return $ts->gte($todayStartLocal) && $ts->lte($todayEndLocal);
            })->values();

            $avgDecibelToday = optional($todayData->pluck('decibels')->filter())->avg();
            $avgDecibelToday = is_null($avgDecibelToday) ? null : round($avgDecibelToday, 2);
            $peakDecibel     = $todayData->pluck('decibels')->filter()->max() ?? null;

            // --- Segments
            $seg12h = $aqiService->computeSegmentedAverages($rangeData, '12h', $nowLocal);
            $seg24h = $aqiService->computeSegmentedAverages($rangeData, '24h', $nowLocal);
            $seg7d  = $aqiService->computeSegmentedAverages($rangeData, '7d',  $endLocalDay);
            $seg30d = $aqiService->computeSegmentedAverages($rangeData, '30d', $nowLocal);

            return [
                'latest_aqi'      => $latestAqi,
                'latest_nowcast'  => $latestNowcast,
                'latest_vals'     => $latestVals,
                'latest_decibel'  => $latestDecibel,
                'peak_decibel'    => $peakDecibel,
                'latest_datetime' => $latestDateTime,
                'avgDecibelToday' => $avgDecibelToday,
                'seg12h'          => $seg12h,
                'seg24h'          => $seg24h,
                'seg7d'           => $seg7d,
                'seg30d'          => $seg30d,
            ];
        });

        return view('front.dashboard', array_merge([
            'hardwares'          => $hardwares,
            'selectedHardwareId' => $selectedHardwareId,
            'selectedHardware'   => $selectedHardware,
            'selectedLat'        => $selectedLat,
            'selectedLon'        => $selectedLon,
        ], $computed));
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

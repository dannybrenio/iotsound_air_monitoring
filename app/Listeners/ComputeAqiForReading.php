<?php

namespace App\Listeners;

use App\Events\ReadingReceived;
use App\Events\DashboardUpdated;
use App\Services\AqiCalculator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Hardware_data;

class ComputeAqiForReading implements ShouldQueue
{
    use InteractsWithQueue;

    public $tries   = 3;
    public $timeout = 60;

    public function __construct(private AqiCalculator $aqi) {}

    public function handle(ReadingReceived $event): void
    {
        // try {
        //     $hardwareId = $event->reading['hardware_id'] ?? null;
    
        //     // 1) Parse the reading's timestamp in Asia/Manila (fallback to now)
        //     $readingTsLocal = isset($event->reading['realtime_stamp'])
        //         ? Carbon::parse($event->reading['realtime_stamp'], 'Asia/Manila')
        //         : Carbon::now('Asia/Manila');
    
        //     // 2) Use the reading time as the window end (no floor)
        //     $endLocal   = $readingTsLocal->copy();
        //     $startLocal = $endLocal->copy()->subHours(12);
    
        //     $recent = Hardware_data::where('hardware_id', $hardwareId)
        //         ->orderByDesc('realtime_stamp')
        //         ->limit(5)
        //         ->get(['realtime_stamp','pm2_5','pm10','decibels']);
    
        //     Log::info('[ComputeAqiForReading] Recent rows (raw DB time)', [
        //         'rows' => $recent->map(fn($r) => [
        //             'ts_raw'   => (string) $r->realtime_stamp,
        //             'ts_iso'   => optional($r->realtime_stamp)?->toIso8601String(),
        //             'pm25'     => $r->pm2_5,
        //             'pm10'     => $r->pm10,
        //             'decibels' => $r->decibels,
        //         ]),
        //     ]);
    
        //     // 3) Right-open interval: [start, end]
        //     $window = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
        //         ->where('hardware_id', $hardwareId)
        //         ->where('realtime_stamp', '>=', $startLocal)
        //         ->where('realtime_stamp', '<=', $endLocal) // inclusive end is fine here
        //         ->orderBy('realtime_stamp')
        //         ->get();
    
        //     Log::info('[ComputeAqiForReading] Window fetched', [
        //         'count'         => $window->count(),
        //         'win_start'     => $startLocal->toIso8601String(),
        //         'win_end'       => $endLocal->toIso8601String(),
        //         'latest_in_db'  => optional($window->last()?->realtime_stamp)?->toIso8601String(),
        //     ]);
    
        //     // 4) Compute AQI/nowcast
        //     $latest     = $window->sortByDesc('realtime_stamp')->first();
        //     $nowcast    = $this->aqi->computeNowCast($window);
        //     $overallAqi = $nowcast['overall_aqi'] ?? null;
    
        //     $appTz    = config('app.timezone', 'Asia/Manila');
        //     $latestTs = null;
        //     if (!empty($latest?->realtime_stamp)) {
        //         // Interpret DB value in app timezone, then keep it in that tz
        //         $latestTs = Carbon::parse($latest->realtime_stamp, $appTz);
        //     }
    
        //     Log::info('[ComputeAqiForReading] Nowcast computed', [
        //         'overall_aqi'      => $overallAqi,
        //         'latest_decibel'   => $latest->decibels ?? null,
        //         'latest_timestamp' => optional($latest?->realtime_stamp)?->toIso8601String(),
        //     ]);
        //     Log::debug('[ComputeAqiForReading] Nowcast detail', $nowcast ?? []);
    
        //     /**
        //      * 5) Today’s decibel stats in Asia/Manila
        //      * Use the reading’s local day as the boundary (startOfDay/endOfDay in app tz).
        //      */
        //     $dayStartLocal = $readingTsLocal->copy()->startOfDay();
        //     $dayEndLocal   = $readingTsLocal->copy()->endOfDay();
    
        //     $todayData = Hardware_data::where('hardware_id', $hardwareId)
        //         ->whereBetween('realtime_stamp', [$dayStartLocal, $dayEndLocal])
        //         ->get(['decibels']);
    
        //     $avgDecibelToday = optional($todayData->pluck('decibels')->filter())->avg();
        //     $avgDecibelToday = is_null($avgDecibelToday) ? null : round($avgDecibelToday, 2);
    
        //     $peakDecibel = $todayData->pluck('decibels')->filter()->max() ?? null;
    
        //     // 6) Broadcast to dashboard
        //     DashboardUpdated::dispatch([
        //         'hardware_id'      => $hardwareId,
        //         'latest_aqi'       => $overallAqi,
        //         'latest_nowcast'   => $nowcast,
        //         'latest_decibel'   => $latest->decibels ?? null,
        //         'average_decibel'  => $avgDecibelToday,   // <-- added
        //         'peak_decibel'     => $peakDecibel,       // <-- added
        //         'latest_datetime'  => $latestTs?->setTimezone($appTz)->toDateTimeString(),
        //     ]);
    
        //     Log::info('[ComputeAqiForReading] Broadcast sent', ['hardware_id' => $hardwareId]);
    
        // } catch (\Throwable $e) {
        //     Log::error('[ComputeAqiForReading] Failed', [
        //         'message' => $e->getMessage(),
        //         'file'    => $e->getFile(),
        //         'line'    => $e->getLine(),
        //     ]);
        //     Log::debug('[ComputeAqiForReading] Trace', ['trace' => $e->getTraceAsString()]);
        //     throw $e;
        // }
    }


    /**
     * Optional: called when job fails after all retries
     */
    public function failed(ReadingReceived $event, \Throwable $e): void
    {
        Log::error('[ComputeAqiForReading] Permanently failed', [
            'hardware_id' => $event->reading['hardware_id'] ?? null,
            'message'     => $e->getMessage(),
        ]);
    }
}

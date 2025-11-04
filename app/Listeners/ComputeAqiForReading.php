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
        try {
            $hardwareId = $event->reading['hardware_id'] ?? null;

            // 1) Parse the reading's timestamp as UTC (fallback to now)
            $readingTsUtc = isset($event->reading['realtime_stamp'])
                ? Carbon::parse($event->reading['realtime_stamp'], 'UTC')
                : Carbon::now('UTC');

            // 2) Use the reading time as the window end (no floor)
            $endUtc   = $readingTsUtc->copy();
            $startUtc = $endUtc->copy()->subHours(12);

            $recent = Hardware_data::where('hardware_id', $hardwareId)
                ->orderByDesc('realtime_stamp')
                ->limit(5)
                ->get(['realtime_stamp','pm2_5','pm10','decibels']);

            Log::info('[ComputeAqiForReading] Recent rows (raw DB time)', [
                'rows' => $recent->map(fn($r) => [
                    'ts_raw'   => (string) $r->realtime_stamp,
                    'ts_iso'   => optional($r->realtime_stamp)?->toIso8601String(), // will show what PHP *thinks* it is
                    'pm25'     => $r->pm2_5,
                    'pm10'     => $r->pm10,
                    'decibels' => $r->decibels,
                ]),
            ]);

            // 3) Right-open interval: [start, end)
            $window = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
                ->where('hardware_id', $hardwareId)
                ->where('realtime_stamp', '>=', $startUtc)
                ->where('realtime_stamp', '<',  $endUtc->copy()->addSecond()) // tolerate same-second writes
                ->orderBy('realtime_stamp')
                ->get();

            Log::info('[ComputeAqiForReading] Window fetched', [
                'count'     => $window->count(),
                'win_start' => $startUtc->toIso8601String(),
                'win_end'   => $endUtc->toIso8601String(),
                'latest_in_db' => optional($window->last()?->realtime_stamp)?->toIso8601String(),
            ]);

            // 3) Compute AQI/nowcast
            $latest     = $window->sortByDesc('realtime_stamp')->first();
            $nowcast    = $this->aqi->computeNowCast($window);
            $overallAqi = $nowcast['overall_aqi'] ?? null;

            $latestTs = null;
            if (!empty($latest?->realtime_stamp)) {
                // If your DB is currently in Asia/Manila, parse with that, then convert if needed
                $appTz    = config('app.timezone', 'Asia/Manila');
                $latestTs = \Carbon\Carbon::parse($latest->realtime_stamp, $appTz);
            }

            Log::info('[ComputeAqiForReading] Nowcast computed', [
                'overall_aqi'      => $overallAqi,
                'latest_decibel'   => $latest->decibels ?? null,
                'latest_timestamp' => optional($latest?->realtime_stamp)?->toIso8601String(),
            ]);
            Log::debug('[ComputeAqiForReading] Nowcast detail', $nowcast ?? []);

            // 4) Broadcast to dashboard
            broadcast(new DashboardUpdated([
                'hardware_id'     => $hardwareId,
                'latest_aqi'      => $overallAqi,
                'latest_nowcast'  => $nowcast,
                'latest_decibel'  => $latest->decibels ?? null,
                'latest_datetime' => $latestTs?->setTimezone($appTz)->toDateTimeString(),
            ]));

            Log::info('[ComputeAqiForReading] Broadcast sent', ['hardware_id' => $hardwareId]);

        } catch (\Throwable $e) {
            Log::error('[ComputeAqiForReading] Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                // Avoid logging huge traces at info level
            ]);
            Log::debug('[ComputeAqiForReading] Trace', ['trace' => $e->getTraceAsString()]);

            // Re-throw so the job can be retried if queued
            throw $e;
        }
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

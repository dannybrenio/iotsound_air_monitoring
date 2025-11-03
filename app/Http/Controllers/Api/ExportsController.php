<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AqiCalculator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportsController extends Controller
{
    public function download(): StreamedResponse
    {
        $file = 'readings-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () {
            $out = fopen('php://output', 'w');
            // fwrite($out, "\xEF\xBB\xBF"); // optional UTF-8 BOM

            fputcsv($out, ['pm2_5','pm10','co','decibels','realtime_stamp']);

            DB::table('hardware_data')
                ->select(['pm2_5','pm10','co','decibels','realtime_stamp'])
                ->orderBy('realtime_stamp')
                ->chunk(1000, function ($rows) use ($out) {
                    foreach ($rows as $r) {
                        fputcsv($out, [
                            $r->pm2_5,
                            $r->pm10,
                            $r->co,
                            $r->decibels,
                            Carbon::parse($r->realtime_stamp)->toDateTimeString(),
                        ]);
                    }
                });
            fclose($out);
        }, 200, $headers);
    }

    public function downloadAqi(AqiCalculator $aqi/*, Collection $window */): StreamedResponse
    {
        // You need to provide a Collection $window of readings for the NowCast window.
        // It must have fields: pm2_5, pm10, co, no2 (and optionally a timestamp field you use elsewhere).
        // Example: $window = $this->readingRepo->lastHours(12); // <- however you already fetch it
        $window = $this->getNowcastWindow(); // <- implement this to return an Illuminate\Support\Collection

        $file = 'aqi-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$file}\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () use ($aqi, $window) {
            $out = fopen('php://output', 'w');

            // New: compute using the current service
            $result = $aqi->computeNowCast($window); // returns per-pollutant AQI + overall_aqi

            // If all values are null (no usable data), write a friendly message and exit
            $allNull = empty(array_filter([
                $result['pm2_5'] ?? null,
                $result['pm10']  ?? null,
                $result['no2']   ?? null,
                $result['co']    ?? null,
                $result['overall_aqi'] ?? null,
            ], fn ($v) => !is_null($v)));

            if ($allNull) {
                fputcsv($out, ['message']);
                fputcsv($out, ['No data available to compute AQI.']);
                fclose($out);
                return;
            }

            // CSV header (kept compatible with your previous file shape)
            fputcsv($out, [
                'type','pm2_5_aqi','pm10_aqi','no2_aqi','co_aqi','overall_aqi','computed_at',
            ]);

            $ts = now()->timezone('Asia/Manila')->toDateTimeString();

            // Only 'nowcast' exists with the new service
            fputcsv($out, [
                'nowcast',
                $result['pm2_5'] ?? null,
                $result['pm10']  ?? null,
                $result['no2']   ?? null,
                $result['co']    ?? null,
                $result['overall_aqi'] ?? null,
                $ts,
            ]);

            fclose($out);
        }, 200, $headers);
    }

    /**
     * Example stub — replace with your real data source.
     * Must return Illuminate\Support\Collection of items having pm2_5, pm10, co, no2.
     */
    private function getNowcastWindow(): Collection
    {
        // e.g., query your readings for the last 12–24h depending on your NowCast window
        // return Reading::where('realtime_stamp', '>=', now('UTC')->subHours(12))->get();
        return collect(); // placeholder
    }

    public function downloadSensorHistory(Request $request): StreamedResponse
    {
        $file = 'sensor_history-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        // Build the base query
        $q = DB::table('history_status')
            ->select(['sensor_type', 'sensor_status', 'created_at'])
            ->orderBy('created_at');

        // Optional filters
        if ($request->filled('type')) {
            $q->where('sensor_type', $request->string('type'));
        }
        if ($request->filled('from')) {
            $q->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $q->whereDate('created_at', '<=', $request->date('to'));
        }

        return response()->stream(function () use ($q) {
            $out = fopen('php://output', 'w');

            // Uncomment if Excel needs UTF-8 BOM:
            // fwrite($out, "\xEF\xBB\xBF");

            // Header row
            fputcsv($out, ['sensor_type', 'sensor_status', 'created_at']);

            // Stream rows in chunks to keep memory low
            $q->chunk(1000, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->sensor_type,
                        $r->sensor_status,
                        // Format timestamp (adjust TZ if desired)
                        Carbon::parse($r->created_at)->timezone('Asia/Manila')->toDateTimeString(),
                    ]);
                }
            });

            fclose($out);
        }, 200, $headers);
    }

    public function downloadAlerts(Request $request): StreamedResponse
    {
        $file = 'alerts-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        // Base query
        $q = DB::table('alerts')
            ->select(['alert_body', 'created_at'])
            ->orderBy('created_at');

        // Optional filters
        if ($request->filled('from')) {
            $q->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $q->whereDate('created_at', '<=', $request->date('to'));
        }

        return response()->stream(function () use ($q) {
            $out = fopen('php://output', 'w');

            // Uncomment if Excel needs UTF-8 BOM:
            // fwrite($out, "\xEF\xBB\xBF");

            // Header
            fputcsv($out, ['alert_body', 'created_at']);

            // Simple CSV-injection hardening for Excel
            $safe = function ($v) {
                $s = (string) $v;
                return preg_match('/^[=+\-@]/', $s) ? "'$s" : $s;
            };
          
            // Stream rows
            $q->chunk(1000, function ($rows) use ($out, $safe) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $safe($r->alert_body),
                        Carbon::parse($r->created_at)->timezone('Asia/Manila')->toDateTimeString(),
                    ]);
                }
            });

            fclose($out);
        }, 200, $headers);
    }
}

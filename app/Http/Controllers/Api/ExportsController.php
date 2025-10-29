<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AqiCalculator;
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

    public function downloadAqi(AqiCalculator $aqi): StreamedResponse
    {
        $file = 'aqi-'.now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s').'.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () use ($aqi) {
            $out = fopen('php://output', 'w');

            $result = $aqi->compute(); // Create separate function since currently 144 readings lang kinukuha, will change this when there's a range
            if (!$result) {
                fputcsv($out, ['message']);
                fputcsv($out, ['No data available to compute AQI.']);
                fclose($out);
                return;
            }

            fputcsv($out, [
                'type','pm2_5_aqi','pm10_aqi','no2_aqi','co_aqi','overall_aqi','computed_at',
            ]);

            $ts = now()->timezone('Asia/Manila')->toDateTimeString();

            fputcsv($out, [
                'instant',
                $result['pollutants']['pm2_5']['instant'] ?? null,
                $result['pollutants']['pm10']['instant'] ?? null,
                $result['pollutants']['no2']['instant'] ?? null,
                $result['pollutants']['co']['instant'] ?? null,
                $result['overall']['instant'] ?? null,
                $ts,
            ]);

            fputcsv($out, [
                'nowcast',
                $result['pollutants']['pm2_5']['nowcast'] ?? null,
                $result['pollutants']['pm10']['nowcast'] ?? null,
                $result['pollutants']['no2']['nowcast'] ?? null,
                $result['pollutants']['co']['nowcast'] ?? null,
                $result['overall']['nowcast'] ?? null,
                $ts,
            ]);

            fclose($out);
        }, 200, $headers);
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

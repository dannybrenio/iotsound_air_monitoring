<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AqiCalculator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class ExportsController extends Controller
{
    public function download(): StreamedResponse
    {
        $file = 'readings-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        return response()->stream(function () {
            $out = fopen('php://output', 'w');
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

    // public function downloadAqi(AqiCalculator $aqi): StreamedResponse
    // {
    //     $window = $this->getNowcastWindow();

    //     $file = 'aqi-full-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';
    //     $headers = [
    //         'Content-Type'        => 'text/csv',
    //         'Content-Disposition' => "attachment; filename=\"{$file}\"",
    //         'Cache-Control'       => 'no-store, no-cache',
    //     ];

    //     return response()->stream(function () use ($aqi, $window) {
    //         DB::connection()->disableQueryLog();
    //         set_time_limit(0);

    //         try {
    //             $out = fopen('php://output', 'w');

    //             // unified header
    //             fputcsv($out, [
    //                 'row_kind','label','start','end',
    //                 'pm2_5_aqi','pm10_aqi','no2_aqi','co_aqi','overall_aqi',
    //                 'avg_decibel','peak_decibel','samples',
    //                 'pm2_5_raw','pm10_raw','no2_raw','co_raw','decibel_raw','reading_timestamp',
    //                 'pm2_5_aqi_inst','pm10_aqi_inst','no2_aqi_inst','co_aqi_inst',
    //                 'exported_at'
    //             ]);

    //             $exportTs = now()->timezone('Asia/Manila')->toDateTimeString();

    //             // SUMMARY
    //             $summary = $aqi->computeNowCast($window);
    //             $allNull = empty(array_filter([
    //                 $summary['pm2_5'] ?? null,
    //                 $summary['pm10'] ?? null,
    //                 $summary['no2'] ?? null,
    //                 $summary['co'] ?? null,
    //                 $summary['overall_aqi'] ?? null,
    //             ], fn ($v) => !is_null($v)));

    //             if ($allNull) {
    //                 fputcsv($out, ['message','','','','','','','','','','','','','','','','','','','','','No data']);
    //                 fclose($out);
    //                 return;
    //             }

    //             fputcsv($out, [
    //                 'summary','','','',
    //                 $summary['pm2_5'] ?? null,
    //                 $summary['pm10'] ?? null,
    //                 $summary['no2'] ?? null,
    //                 $summary['co'] ?? null,
    //                 $summary['overall_aqi'] ?? null,
    //                 '','','',
    //                 '','','','','','',
    //                 '','','','',
    //                 $exportTs
    //             ]);

    //             // SEGMENTS
    //             $segments = $aqi->computeSegmentedAverages($window, '12h', null, 'realtime_stamp');
    //             foreach ($segments as $seg) {
    //                 // ✅ Fixed the is_numeric() issue here:
    //                 $overall = collect([
    //                     $seg['pm2_5'] ?? null,
    //                     $seg['pm10'] ?? null,
    //                     $seg['no2'] ?? null,
    //                     $seg['co'] ?? null,
    //                 ])->filter(fn ($v) => is_numeric($v))->max();

    //                 fputcsv($out, [
    //                     'segment',
    //                     $seg['label'] ?? null,
    //                     $seg['start'] ?? null,
    //                     $seg['end'] ?? null,
    //                     $seg['pm2_5'] ?? null,
    //                     $seg['pm10'] ?? null,
    //                     $seg['no2'] ?? null,
    //                     $seg['co'] ?? null,
    //                     $overall,
    //                     $seg['avg_decibel'] ?? null,
    //                     $seg['peak_decibel'] ?? null,
    //                     $seg['samples'] ?? null,
    //                     '','','','','','',
    //                     '','','','',
    //                     $exportTs
    //                 ]);
    //             }

    //             // RAW rows + instantaneous AQI
    //             foreach ($window as $r) {
    //                 $inst = $aqi->convertInstantAQIForRow($r);

    //                 fputcsv($out, [
    //                     'raw','','','',
    //                     '','','','','',
    //                     '','','',
    //                     $r->pm2_5 ?? null,
    //                     $r->pm10 ?? null,
    //                     $r->no2 ?? null,
    //                     $r->co ?? null,
    //                     ($r->decibel ?? $r->decibels ?? null),
    //                     Carbon::parse($r->realtime_stamp, 'UTC')
    //                         ->timezone('Asia/Manila')->toDateTimeString(),
    //                     $inst['pm2_5'] ?? null,
    //                     $inst['pm10'] ?? null,
    //                     $inst['no2'] ?? null,
    //                     $inst['co'] ?? null,
    //                     $exportTs
    //                 ]);
    //             }

    //             fclose($out);
    //         } catch (\Throwable $e) {
    //             Log::error('downloadAqi() stream failed: ' . $e->getMessage(), [
    //                 'trace' => $e->getTraceAsString(),
    //             ]);

    //             $out = fopen('php://output', 'w');
    //             fputcsv($out, ['message']);
    //             fputcsv($out, ['Internal error generating CSV. Check server logs.']);
    //             fclose($out);
    //         }
    //     }, 200, $headers);
    // }
    
    public function downloadAqi(AqiCalculator $aqi): StreamedResponse
    {
        $window = $this->getNowcastWindow();
    
        $file = 'aqi-raw-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$file}\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];
    
        return response()->stream(function () use ($aqi, $window) {
            DB::connection()->disableQueryLog();
            set_time_limit(0);
    
            try {
                $out = fopen('php://output', 'w');
    
                // Header: raw values + instantaneous AQI per reading
                fputcsv($out, [
                    'pm2_5_raw','pm10_raw','no2_raw','co_raw','decibel_raw','reading_timestamp',
                    'pm2_5_aqi_inst','pm10_aqi_inst','no2_aqi_inst','co_aqi_inst',
                ]);
    
                $exportTs = now()->timezone('Asia/Manila')->toDateTimeString();
    
                // Rows: RAW readings only
                foreach ($window as $r) {
                    $inst = $aqi->convertInstantAQIForRow($r);
    
                    fputcsv($out, [
                        $r->pm2_5 ?? null,
                        $r->pm10  ?? null,
                        $r->no2   ?? null,
                        $r->co    ?? null,
                        // tolerate either column name
                        ($r->decibel ?? $r->decibels ?? null),
                        \Carbon\Carbon::parse($r->realtime_stamp, 'UTC')->timezone('Asia/Manila')->toDateTimeString(),
    
                        // instantaneous AQI (per reading, not NowCast)
                        $inst['pm2_5'] ?? null,
                        $inst['pm10']  ?? null,
                        $inst['no2']   ?? null,
                        $inst['co']    ?? null,
    
                    ]);
                }
    
                fclose($out);
            } catch (\Throwable $e) {
                \Log::error('downloadAqi() stream failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);
                $out = fopen('php://output', 'w');
                fputcsv($out, ['message']);
                fputcsv($out, ['Internal error generating CSV. Check server logs.']);
                fclose($out);
            }
        }, 200, $headers);
    }


    private function getNowcastWindow(): Collection
    {
        return DB::table('hardware_data')
            ->select(['pm2_5','pm10','co','no2','decibels','realtime_stamp'])
            ->orderBy('realtime_stamp', 'asc')
            ->get();
    }

    public function downloadSensorHistory(Request $request): StreamedResponse
    {
        $file = 'sensor_history-' . now()->timezone('Asia/Manila')->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$file\"",
            'Cache-Control'       => 'no-store, no-cache',
        ];

        $q = DB::table('history_status')
            ->select(['sensor_type', 'sensor_status', 'created_at'])
            ->orderBy('created_at');

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
            fputcsv($out, ['sensor_type', 'sensor_status', 'created_at']);

            $q->chunk(1000, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->sensor_type,
                        $r->sensor_status,
                        Carbon::parse($r->created_at)
                            ->timezone('Asia/Manila')->toDateTimeString(),
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

        $q = DB::table('alerts')
            ->select(['alert_body', 'created_at'])
            ->orderBy('created_at');

        if ($request->filled('from')) {
            $q->whereDate('created_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $q->whereDate('created_at', '<=', $request->date('to'));
        }

        return response()->stream(function () use ($q) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['alert_body', 'created_at']);

            $safe = function ($v) {
                $s = (string) $v;
                return preg_match('/^[=+\-@]/', $s) ? "'$s" : $s;
            };

            $q->chunk(1000, function ($rows) use ($out, $safe) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $safe($r->alert_body),
                        Carbon::parse($r->created_at)
                            ->timezone('Asia/Manila')->toDateTimeString(),
                    ]);
                }
            });

            fclose($out);
        }, 200, $headers);
    }
}

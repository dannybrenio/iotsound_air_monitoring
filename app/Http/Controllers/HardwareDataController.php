<?php

namespace App\Http\Controllers;

use App\Events\ReadingReceived;
use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Models\Alerts;
use App\Models\History_status;
use App\Models\Pending_hardware_data;
use App\Models\Pending_hardware;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\DashboardUpdated;

class HardwareDataController extends Controller
{
    public function index()
    {
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

        $hardware_data = Hardware_data::with('hardware')
            ->latest('data_id')
            ->paginate(10);

        return view('admin.hardware.admin_hardware_data', compact('hardware_data', 'notifs'));
    }

    private function mapAqiToLabel(?float $aqi): ?string
    {
        if ($aqi === null) return null;
        if ($aqi <= 35)  return "Fair Air Quality";
        if ($aqi <= 45)  return "Poor Air Quality";
        if ($aqi <= 55)  return "Unhealthy Air Quality";
        if ($aqi <= 90) return "Acutely Unhealthy Air Quality";
        return "Emergency, Evacuation Advised!";
    }

    private function mapDbToLabel(?float $db): ?string
    {
        if ($db === null) return null;

        // Tweak thresholds to your policy as needed:
        if ($db <= 60)  return 'Moderate Noise';   // typical conversation / residential daytime
        if ($db <= 80)  return 'Loud Noise';       // busy traffic
        if ($db <= 100)  return 'Very Loud Noise';  // risk increases with exposure duration
        return 'Hazardous Noise';                  // >85 dB: hearing risk w/ prolonged exposure
    }


    public function receiveData(Request $request)
    {
        try {
            $rawdata = $request->json()->all();

            // $rtPht = isset($rawdata['realtime_stamp'])
            //     ? Carbon::parse($rawdata['realtime_stamp'], 'UTC')->setTimezone('Asia/Manila')
            //     : null;
    
            $rtPht = isset($rawdata['realtime_stamp'])
                ? Carbon::parse($rawdata['realtime_stamp'])->setTimezone('Asia/Manila')
                : null;


            Log::info("Time received", ["Time" => $rtPht]);

            $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');

            // --- Pending hardware branch ---
            if (empty($hardware_id)) {
                Pending_hardware_data::create([
                    'pending_hardware_info' => $rawdata['hardware_info'],
                    'pm2_5'         => $rawdata['pm2_5']   ?? null,
                    'pm10'          => $rawdata['pm10']    ?? null,
                    'co'            => $rawdata['co']      ?? null,
                    'no2'           => $rawdata['no2']     ?? null,
                    'decibels'      => $rawdata['decibels']?? null,
                    'realtime_stamp'=> $rtPht ?? $rawdata['realtime_stamp'],
                ]);

                // $aqiService = new AqiCalculator();
                // $today = Carbon::today('Asia/Manila');
                // $todayData = Hardware_data::whereBetween('realtime_stamp', [
                //     $today->copy()->startOfDay(),
                //     $today->copy()->endOfDay(),
                // ])->get();

                // $latestNowcast  = $aqiService->computeNowCast($todayData);
                // $latestAqi      = $latestNowcast['overall_aqi'] ?? null;
                // $aqiLevel       = $this->mapAqiToLabel($latestAqi);

                // Log::info("HARDWARE (pending)", [
                //     "hardware" => $rawdata['hardware_info'],
                //     "aqi"      => $latestAqi,
                // ]);

                $pending = Pending_hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_info');
                if (empty($pending)) {
                    Pending_hardware::create([
                        'hardware_info' => $rawdata['hardware_info'],
                        'longitude'     => $rawdata['longitude'] ?? null,
                        'latitude'      => $rawdata['latitude'] ?? null,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'hardware_info' => $rawdata['hardware_info'],
                    'message' => 'Hardware ID not found, added to pending data.',
                ], 200);
            }

            // --- Normal hardware branch ---
            $hardware_data = Hardware_data::create([
                'hardware_id'     => $hardware_id,
                'pm2_5'           => $rawdata['pm2_5'] ?? null,
                'pm10'            => $rawdata['pm10'] ?? null,
                'co'              => $rawdata['co'] ?? null,
                'no2'             => $rawdata['no2'] ?? null,
                'decibels'        => $rawdata['decibels'] ?? null,
                'realtime_stamp'  => $rtPht ?? $rawdata['realtime_stamp'] ?? null,
            ]);

            ReadingReceived::dispatch([
                'hardware_id'    => $hardware_data->hardware_id,
                'pm2_5'          => $hardware_data->pm2_5,
                'pm10'           => $hardware_data->pm10,
                'co'             => $hardware_data->co,
                'no2'            => $hardware_data->no2,
                'decibels'       => $hardware_data->decibels,
                'realtime_stamp' => $hardware_data->realtime_stamp,
            ]);

            $this->updateDashboard($hardware_data);

            if ($hardware_data) {
                $aqiService = new AqiCalculator();
                $today = Carbon::today('Asia/Manila');
                $todayData = Hardware_data::whereBetween('realtime_stamp', [
                    $today->copy()->startOfDay(),
                    $today->copy()->endOfDay(),
                ])->get();

                $latestNowcast  = $aqiService->computeNowCast($todayData);
                $latestAqi      = $latestNowcast['overall_aqi'] ?? null;
                $aqiLevel       = $this->mapAqiToLabel($latestAqi);

                $decibelValue = $hardware_data->decibels;

                $dbLabel = $this->mapDbToLabel(
                    isset($decibelValue) ? (float)$decibelValue : null
                );

                // Keep sending `db` (your client doesn’t parse it, it just triggers _loadLatestDecibel())
                FCMv1Controller::sendDataOnly([
                    'type'           => 'reading',
                    'hardware_info'  => (string)$rawdata['hardware_info'],
                    'pm2_5'          => (string)$hardware_data->pm2_5,
                    'pm10'           => (string)$hardware_data->pm10,
                    'db'             => $decibelValue !== null ? (string)$decibelValue : '',
                    'aqi'            => (string)($latestAqi ?? ''),
                    'aqi_label'      => $aqiLevel,
                    'db_label'       => $this->mapDbToLabel($decibelValue),
                    'ts'             => ($rtPht ?? Carbon::now('Asia/Manila'))->toIso8601String(),
                ]);
                
                if ($aqiLevel || $dbLabel) {
                    $alertsController = new AlertsController();
                    // Pass both; nulls are fine
                    $alertsController->store($rawdata['hardware_info'], $aqiLevel, $dbLabel);
                }
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

        return response()->noContent();
    }

    public function updateDashboard(Hardware_data $hardwareData): void
    {
        try {
            // Use the stored hardware_id directly from the model
            $hardwareId = $hardwareData->hardware_id;
            if (empty($hardwareId)) {
                Log::warning('[updateDashboard] Missing hardware_id on Hardware_data model.', ['data_id' => $hardwareData->data_id ?? null]);
                return;
            }

            // App timezone
            $appTz = config('app.timezone', 'Asia/Manila');

            // Reading timestamp in app timezone (fallback: now)
            $readingTsLocal = $hardwareData->realtime_stamp
                ? Carbon::parse($hardwareData->realtime_stamp, $appTz)
                : Carbon::now($appTz);

            // Define the 12-hour window ending at the reading timestamp
            $endLocal   = $readingTsLocal->copy();
            $startLocal = $endLocal->copy()->subHours(12);

            // Optional: quick recent log for debugging
            $recent = Hardware_data::where('hardware_id', $hardwareId)
                ->orderByDesc('realtime_stamp')
                ->limit(5)
                ->get(['realtime_stamp','pm2_5','pm10','decibels']);

            Log::info('[updateDashboard] Recent rows', [
                'rows' => $recent->map(fn($r) => [
                    'ts'       => optional($r->realtime_stamp)?->toIso8601String(),
                    'pm2_5'    => $r->pm2_5,
                    'pm10'     => $r->pm10,
                    'decibels' => $r->decibels,
                ]),
            ]);

            // Fetch the window [startLocal, endLocal]
            $window = Hardware_data::select(['realtime_stamp','pm2_5','pm10','no2','co','decibels'])
                ->where('hardware_id', $hardwareId)
                ->where('realtime_stamp', '>=', $startLocal)
                ->where('realtime_stamp', '<=', $endLocal) // inclusive end is fine
                ->orderBy('realtime_stamp')
                ->get();

            Log::info('[updateDashboard] Window fetched', [
                'count'     => $window->count(),
                'win_start' => $startLocal->toIso8601String(),
                'win_end'   => $endLocal->toIso8601String(),
                'latest_ts' => optional($window->last()?->realtime_stamp)?->toIso8601String(),
            ]);

            if ($window->isEmpty()) {
                Log::warning('[updateDashboard] No data in window; nothing to broadcast.', [
                    'hardware_id' => $hardwareId,
                    'start'       => $startLocal->toIso8601String(),
                    'end'         => $endLocal->toIso8601String(),
                ]);
                return;
            }

            // Compute AQI/nowcast using the service (not $this->aqi)
            $aqiService = new AqiCalculator();
            $nowcast    = $aqiService->computeNowCast($window);
            $overallAqi = $nowcast['overall_aqi'] ?? null;

            // get the latest row by timestamp defensively
            $latest = $window->sortByDesc('realtime_stamp')->first();

            $latestTs = null;
            if (!empty($latest?->realtime_stamp)) {
                // handle both string and Carbon cases
                if ($latest->realtime_stamp instanceof \Carbon\CarbonInterface) {
                    $latestTs = $latest->realtime_stamp->copy()->timezone($appTz);
                } else {
                    $latestTs = Carbon::parse((string)$latest->realtime_stamp, $appTz);
                }
            }

            Log::info('[updateDashboard] Nowcast computed', [
                'overall_aqi'      => $overallAqi,
                'latest_decibel'   => $latest->decibels ?? null,
                'latest_timestamp' => $latestTs?->toIso8601String(),
            ]);
            Log::debug('[updateDashboard] Nowcast detail', $nowcast ?? []);

            // Today’s decibel stats based on the reading’s local day
            $dayStartLocal = $readingTsLocal->copy()->startOfDay();
            $dayEndLocal   = $readingTsLocal->copy()->endOfDay();

            $todayData = Hardware_data::where('hardware_id', $hardwareId)
                ->whereBetween('realtime_stamp', [$dayStartLocal, $dayEndLocal])
                ->get(['decibels']);

            $decibelSeries    = $todayData->pluck('decibels')->filter(fn($v) => $v !== null);
            $avgDecibelToday  = $decibelSeries->isEmpty() ? null : round($decibelSeries->avg(), 2);
            $peakDecibel      = $decibelSeries->isEmpty() ? null : $decibelSeries->max();

            // Broadcast to dashboard listeners
            DashboardUpdated::dispatch([
                'hardware_id'      => $hardwareId,
                'latest_aqi'       => $overallAqi,
                'latest_nowcast'   => $nowcast,
                'latest_decibel'   => $latest->decibels ?? null,
                'average_decibel'  => $avgDecibelToday,
                'peak_decibel'     => $peakDecibel,
                'latest_datetime'  => $latestTs?->toDateTimeString(), // will no longer be null
            ]);

            Log::info('[updateDashboard] Broadcast sent', ['hardware_id' => $hardwareId]);
        } catch (\Throwable $e) {
            Log::error('[updateDashboard] Failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);
            Log::debug('[updateDashboard] Trace', ['trace' => $e->getTraceAsString()]);
            // Re-throw if you want the caller to handle it; otherwise swallow.
            throw $e;
        }
    }

}

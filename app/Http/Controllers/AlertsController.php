<?php

namespace App\Http\Controllers;

use App\Events\SensorMalfunctioned;
use App\Models\Alerts;
use App\Models\History_status;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AlertsController extends Controller
{
    public function index()
    {
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        $alerts = Alerts::paginate(10);
        return view('admin.alert.admin_alert', compact('alerts', 'notifs'));
    }

    public function store(string $hardwareIdentifyer, ?string $aqiLevel = null, ?string $dbLabel = null)
    {
        Log::info('AlertsController@store called', [
            'hardware' => $hardwareIdentifyer,
            'aqiLevel' => $aqiLevel,
            'dbLabel'  => $dbLabel,
            'env_now'  => now('Asia/Manila')->toIso8601String(),
        ]);

        $airCreated   = false;
        $noiseCreated = false;

        // --- Helpers ---
        $latestFor = function (string $type, string $hardware) {
            $prefix = strtoupper($type) . ': ';
            return Alerts::where('alert_body', 'like', $prefix . '% from ' . $hardware)
                ->orderByDesc('created_at')
                ->first();
        };

        $extractLabel = function (string $type, string $body): ?string {
            // "AIR: {label} from {hardware}" / "NOISE: {label} from {hardware}"
            $type = strtoupper($type);
            $pattern = '/^' . preg_quote($type, '/') . ':\s(.+)\sfrom\s.+$/u';
            if (preg_match($pattern, $body, $m)) {
                return $m[1] ?? null;
            }
            return null;
        };

        $hasChanged = function (string $type, string $hardware, string $newLabel) use ($latestFor, $extractLabel): array {
            $latest = $latestFor($type, $hardware);
            if (!$latest) {
                return [true, null]; // no previous alert → treat as a change (send)
            }
            $prevLabel = $extractLabel($type, (string)($latest->alert_body ?? ''));
            $changed   = $prevLabel !== $newLabel;
            return [$changed, $prevLabel];
        };

        // =========================
        //           AIR
        // =========================
        if (!empty($aqiLevel)) {
            $airBody = "AIR: {$aqiLevel} from {$hardwareIdentifyer}";
            Log::info('AIR alert composed', ['body' => $airBody]);

            [$airChanged, $prevAirLabel] = $hasChanged('air', $hardwareIdentifyer, $aqiLevel);

            Log::info('AIR change decision', [
                'previous_label' => $prevAirLabel,
                'new_label'      => $aqiLevel,
                'changed'        => $airChanged,
            ]);

            if ($airChanged) {
                try {
                    FCMv1Controller::send(
                        'ALERT!',
                        $aqiLevel,
                        [
                            'type'     => 'air',
                            'hardware' => $hardwareIdentifyer,
                        ]
                    );
                    Log::info('AIR FCM sent', [
                        'hardware' => $hardwareIdentifyer,
                        'aqiLevel' => $aqiLevel,
                    ]);
                } catch (\Throwable $e) {
                    Log::error('AIR FCM send failed', ['error' => $e->getMessage()]);
                }

                $alert = Alerts::create(['alert_body' => $airBody]);
                $airCreated = true;

                Log::info('AIR alert created', [
                    'alert_pk' => method_exists($alert, 'getKey') ? $alert->getKey() : ($alert->id ?? null),
                    'body'     => $airBody,
                ]);
            } else {
                Log::info('AIR alert suppressed (label unchanged)', [
                    'label' => $aqiLevel,
                ]);
            }
        } else {
            Log::info('AIR alert skipped (no aqiLevel provided)');
        }

        // =========================
        //          NOISE
        // =========================
        if (!empty($dbLabel)) {
            $noiseBody = "NOISE: {$dbLabel} from {$hardwareIdentifyer}";
            Log::info('NOISE alert composed', ['body' => $noiseBody]);

            [$noiseChanged, $prevNoiseLabel] = $hasChanged('noise', $hardwareIdentifyer, $dbLabel);

            Log::info('NOISE change decision', [
                'previous_label' => $prevNoiseLabel,
                'new_label'      => $dbLabel,
                'changed'        => $noiseChanged,
            ]);

            if ($noiseChanged) {
                try {
                    FCMv1Controller::send(
                        'ALERT!',
                        $dbLabel,
                        [
                            'type'     => 'noise',
                            'hardware' => $hardwareIdentifyer,
                        ]
                    );
                    Log::info('NOISE FCM sent', [
                        'hardware' => $hardwareIdentifyer,
                        'dbLabel'  => $dbLabel,
                    ]);
                } catch (\Throwable $e) {
                    Log::error('NOISE FCM send failed', ['error' => $e->getMessage()]);
                }

                $alert = Alerts::create(['alert_body' => $noiseBody]);
                $noiseCreated = true;

                Log::info('NOISE alert created', [
                    'alert_pk' => method_exists($alert, 'getKey') ? $alert->getKey() : ($alert->id ?? null),
                    'body'     => $noiseBody,
                ]);
            } else {
                Log::info('NOISE alert suppressed (label unchanged)', [
                    'label' => $dbLabel,
                ]);
            }
        } else {
            Log::info('NOISE alert skipped (no dbLabel provided)');
        }

        Log::info('AlertsController@store finished', [
            'hardware'     => $hardwareIdentifyer,
            'airCreated'   => $airCreated,
            'noiseCreated' => $noiseCreated,
        ]);

        return response()->json([
            'message'       => 'Alerts processed',
            'air_created'   => $airCreated,
            'noise_created' => $noiseCreated,
        ]);
    }


    public function receiveSensorStatus(Request $request)
    {
        $rawdata = $request->json()->all();
        Log::info('receiveSensorStatus payload', $rawdata);

        SensorMalfunctioned::dispatch([
            "hardware_info" => $rawdata["hardware_info"] ?? null,
            "sensor_type"   => $rawdata["sensor_type"] ?? null,
            "sensor_status" => $rawdata["sensor_status"] ?? null
        ]);

        return response()->json(['message' => "Sensor status received :> yay"], 200);
    }
}

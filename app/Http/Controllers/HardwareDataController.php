<?php

namespace App\Http\Controllers;

use App\Events\ReadingReceived;
use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Models\Alerts;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\PendingHardwareDataController;
use App\Models\Pending_hardware_data;
use App\Services\AqiCalculator;
use Exception;
use Illuminate\Http\Request;

class HardwareDataController extends Controller
{

    public function index()
    {
        $hardware_data = Hardware_data::with('hardware')
            ->latest('data_id') // or any ordering you need
            ->paginate(10);

        return view('admin.hardware.admin_hardware_data', compact('hardware_data'));
    }


 public function receiveData(Request $request){
    try{
        // if ($request->header('X-Device-Key') !== env('DEVICE_API_KEY')) {
        //     return response()->json(['message' => 'Unauthorized Access'], 401);
        // }

        $rawdata = $request->json()->all();
            ReadingReceived::dispatch([
                'hardware_id'    => "1",
                'pm2_5'          => $rawdata["pm2_5"],
                'pm10'           => $rawdata["pm10"],
                'co'             => $rawdata["co"],
                'no2'            => $rawdata["no2"],
                'decibels'       => $rawdata["decibels"],
                'realtime_stamp' => $rawdata["realtime_stamp"],
            ]);

        FCMv1Controller::send(
            'New reading',
            sprintf('PM2.5: %.1f | PM10: %.1f | dB: %.1f', $rawdata["pm2_5"], $rawdata["pm10"], $rawdata["decibels"]),
            [
                'pm2_5' => (string)$rawdata["pm2_5"],
                'pm10'  => (string)$rawdata["pm10"],
                'db'    => (string)$rawdata["decibels"],
            ]
        );
        return response()->json(['message' => $rawdata], 200);
        $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');
        
         if(empty($hardware_id)){ 
            Pending_hardware_data::create([
                'pending_hardware_info' => $rawdata['hardware_info'],
                'pm2_5'         => $rawdata['pm2_5']   ?? null,
                'pm10'          => $rawdata['pm10']    ?? null,
                'co'            => $rawdata['co']      ?? null,
                'no2'           => $rawdata['no2']     ?? null,
                'decibels'      => $rawdata['decibels']?? null,
                'realtime_stamp'=> $rawdata['realtime_stamp'] ?? null,
            ]);
            return response()->json(['success' => true, 
            'hardware_info' => $rawdata['hardware_info'],
            'message' => 'Hardware ID not found, added to pending data.'], 200);
         }

            $hardware_data = Hardware_data::create([
                'hardware_id' => $hardware_id,
                'pm2_5' => $rawdata['pm2_5'] ?? null,
                'pm10' => $rawdata['pm10'] ?? null,
                'co' => $rawdata['co'] ?? null,
                'no2' => $rawdata['no2'] ?? null,
                'decibels' => $rawdata['decibels'] ?? null,
                'realtime_stamp' => $rawdata['realtime_stamp'] ?? null,
            ]);

            ReadingReceived::dispatch([
                'hardware_id' => $hardware_data->hardware_id,
                'pm2_5' => $hardware_data->pm2_5,
                'pm10' => $hardware_data->pm10,
                'co' => $hardware_data->co,
                'no2' => $hardware_data->no2,
                'decibels' => $hardware_data->decibels,
                'realtime_stamp' => $hardware_data->realtime_stamp,
            ]);

            if ($hardware_data) {
                $aqiService = new AqiCalculator();
                $alertData = $aqiService->compute();

                // 1) Normalize payload whether compute() returned array or JsonResponse
                $payload = $alertData instanceof \Illuminate\Http\JsonResponse
                    ? $alertData->getData(true)   // associative array
                    : $alertData;

                // 2) Pull overall nowcast AQI
                $overallNowcast = $payload['overall']['nowcast'] ?? null;

                // 3) Map to your 6-level thresholds
                $aqiLevel = null;
                if ($overallNowcast !== null) {
                    $aqi = (int) $overallNowcast;
                    $aqiLevel = match (true) {
                        $aqi <= 25 => 'good',
                        $aqi <= 35 => 'fair',
                        $aqi <= 45 => 'unhealthy',
                        $aqi <= 55 => 'very unhealthy',
                        $aqi <= 300 => 'acutely unhealthy',
                        default => 'emergency',
                    };
                }

                //4) (Optional) Call your alert logic (uncomment if you want to persist alerts)
                $alertsController = new AlertsControlle90r();
                $alertsController->store($aqiLevel);

                // 5) Return original payload + computed level (without changing AqiCalculator)
                $final = $payload ?? [];
                $final['overall'] = array_merge($final['overall'] ?? [], [
                    'nowcast_level' => $aqiLevel,
                ]);

                return response()->json(['message' => 'New ALert!']);
            }


        } catch (Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
        return response()->noContent();
    }


}
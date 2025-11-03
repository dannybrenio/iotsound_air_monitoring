<?php

namespace App\Http\Controllers;

use App\Events\ReadingReceived;
use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Models\Alerts;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\PendingHardwareDataController;
use App\Models\Pending_hardware;
use App\Models\Pending_hardware_data;
use App\Services\AqiCalculator;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $provided = $request->header('X-Device-Key');         // string|null
        $expected = config('services.device.key') ?? '';       // string ('' if unset)

        if (!$provided || !hash_equals($expected, $provided)) {
            return response()->json(['message' => 'Unauthorized Access!'], 401);
        }

        $rawdata = $request->json()->all();
        //     ReadingReceived::dispatch([
        //         'hardware_id'    => "1",
        //         'pm2_5'          => $rawdata["pm2_5"],
        //         'pm10'           => $rawdata["pm10"],
        //         'co'             => $rawdata["co"],
        //         'no2'            => $rawdata["no2"],
        //         'decibels'       => $rawdata["decibels"],
        //         'realtime_stamp' => $rawdata["realtime_stamp"],
        //     ]);

        FCMv1Controller::send(
            'New reading',
            sprintf('PM2.5: %.1f | PM10: %.1f | dB: %.1f', $rawdata["pm2_5"], $rawdata["pm10"], $rawdata["decibels"]),
            [
                'pm2_5' => (string)$rawdata["pm2_5"],
                'pm10'  => (string)$rawdata["pm10"],
                'db'    => (string)$rawdata["decibels"],
            ]
        );
        // return response()->json(['message' => $rawdata], 200);
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

            $pending = Pending_hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');

            if (empty($pending)){
                Pending_hardware::create([
                    'hardware_info' => $rawdata['hardware_info'],
                    'longitude' => $rawdata['longitude'],
                    'latitude' => $rawdata['latitude']
                ]);
            }

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


            if($hardware_data){

                 $aqiService = new AqiCalculator();
        
                $today = Carbon::today();
                $todayData = Hardware_data::whereDate('realtime_stamp', $today)->get();
                $latestNowcast  = $aqiService->computeNowCast($todayData);
                $latestAqi      = $latestNowcast['overall_aqi'] ?? null;

                //DONT KNOW WHAT TO DO WITH DECIBELS
                
                if($latestAqi <= 35){
                   // return response()->json(['message' => 'MODERATE AIR!']);
                    $aqiLevel = "moderate air quality";
                }elseif($latestAqi <= 45){
                   // return response()->json(['message' => 'POOR AIR!']);
                    $aqiLevel = "poor air quality";
                }elseif($latestAqi <= 55){
                    //return response()->json(['message' => 'UNHEALTHY AIR!']);
                    $aqiLevel = "unhealthy air quality";
                }elseif($latestAqi <= 90){
                    //return response()->json(['message' => 'SEVERE AIR!']);
                    $aqiLevel = "severe air quality";
                }elseif($latestAqi > 100){
                //  return response()->json(['message' => 'EMERGENCY!',
                // 'AQI' => $latestAqi]);
                    $aqiLevel = "emergency, evacuation advised!";
                }

                 $alertsController = new AlertsController();
                 $alertsController->store($aqiLevel);

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
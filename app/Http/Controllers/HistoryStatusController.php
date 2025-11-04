<?php

namespace App\Http\Controllers;

use App\Events\SensorMalfunctioned;
use App\Models\History_status;
use App\Models\Device_status;
use Exception;
use Illuminate\Http\Request;

class HistoryStatusController extends Controller
{
   
    public function index()
    {
        $notifs = History_status::where('isRead', 0)->get();

        $history_statuses = History_status::with('device_Status')
         ->latest('status_id') // or any ordering you need
        ->get();
        return view('admin.history_status.admin_history_status', compact('history_statuses', 'notifs'));
    }

   private const POINTER_MAP = [
                'pms' => 'pms_status',
                'mq135' => 'mq135_status',
                'mq7' => 'mq7_status',
                'sound' => 'sound_status',
                'time' => 'timestamp_status',
                    ];

    public function receiveStatus(Request $request){

        try{
            $rawdata = $request->json()->all();
            
            SensorMalfunctioned::dispatch([
                "hardware_info" => $rawdata["hardware_info"],
                "sensor_type" => $rawdata["sensor_type"],
                "sensor_status" => $rawdata["sensor_status"]
            ]);    

            $device_status_id = Device_status::where('hardware_info', $rawdata['hardware_info'])->value('status_id');

            // return response()->json([ 
            //     'status_id' => $device_status_id,
            // ]);

            if(!$device_status_id){
                 return response()->json([
                    'hardware_info' => $rawdata['hardware_info'],
                    'message' => 'Device not Registed' 
                ], 200);
            }

            $history_status_create = History_status::create([
                'status_id' => $device_status_id,
                'sensor_type' => $rawdata['sensor_type'],
                'sensor_status' => $rawdata['sensor_status'],
                'isRead' => 0
            ]);

            if($history_status_create){
            
                $pointer_column = self::POINTER_MAP[$rawdata['sensor_type']];
                Device_status::where('status_id', $device_status_id)->update([$pointer_column => $rawdata['sensor_status']]);

                return response()->json([
                    'sucess' => true,
                    'hardware_info' => $rawdata['hardware_info'],
                    'sensor_type' => $rawdata['sensor_type'],
                    'sensor_status' => $rawdata['sensor_status'],
                    'message' => 'Device Status Added' 
                ], 200);
            }

        }catch (Exception $e){
            return response()->json([
            'error'   => 'Server Error',
            'message' => $e->getMessage(),
            'trace'   => $e->getTrace()
        ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\PendingHardwareDataController;
use Exception;
use Illuminate\Http\Request;

class HardwareDataController extends Controller
{

 public function index(){   
        $hardware_data = Hardware_data::all();
        return view('admin.hardware.hardware_data', compact('hardware_data'));
  }
  

 public function receiveData(Request $request){

    try{
        $rawdata = $request->json()->all();

        $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');
         if(empty($hardware_id)){ 
            $PendingHardwareDataController = new PendingHardwareDataController();
            $PendingHardwareDataController->store($rawdata['hardware_info'],$rawdata['pm2_5'], $rawdata['pm10'], $rawdata['co'], $rawdata["no2"], $rawdata["decibels"], $rawdata["realtime_stamp"]);
            return response()->json(['success' => true, 
            'hardware_info' => $rawdata['hardware_info'],
            'message' => 'Hardware ID not found, added to pending data.'], 200);
         }

            $hardware_data = Hardware_data::create([
                'hardware_id' => $hardware_id,
                'pm2_5' => $rawdata['pm2_5'] ?? null,
                'pm10' => $rawdata['pm10']?? null,
                'co' => $rawdata['co']?? null,
                'no2' => $rawdata['no2']?? null,
                'decibels' => $rawdata['decibels']?? null,
                'realtime_stamp' => $rawdata['realtime_stamp']?? null,
            ]);

            if($hardware_data){
                $alertsController = new AlertsController();
                $alertsController->store($rawdata['pm2_5'], $rawdata['pm10'], $rawdata['co'], $rawdata["no2"], $rawdata["decibels"]);
            }
    } catch (Exception $e) {
        return response()->json([
            'error'   => 'Server Error',
            'message' => $e->getMessage(),
            'trace'   => $e->getTrace()
        ], 500);
    }
  }

}

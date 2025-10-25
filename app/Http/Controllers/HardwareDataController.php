<?php

namespace App\Http\Controllers;

use App\Events\ReadingReceived;
use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Http\Controllers\AlertsController;
use App\Models\Pending_hardware;
use Carbon\Carbon;
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
        if ($request->header('X-Device-Key') !== env('DEVICE_API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $rawdata = $request->json()->all();

        $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');
        
        if(empty($hardware_id)){
            Pending_hardware::firstOrCreate(
                ['hardware_info' => $request->input('hardware_info')],
                [
                    'longitude' => $request->input('longitude', null),
                    'latitude'  => $request->input('latitude', null),
                ]
            );
 
            return response()->json(['error'   => 'Hardware ID not found.'], 404);
        }

        $iso = $rawdata['realtime_stamp'] ?? null;

        if ($iso) {
            // Parse ISO 8601 and store as "Y-m-d H:i:s"
            $realtime = Carbon::parse($iso)->toDateTimeString();          // e.g., "2025-10-24 09:10:11"
        } elseif (isset($rawdata['ts'])) {
            // Or accept epoch seconds from device
            $realtime = Carbon::createFromTimestampUTC($rawdata['ts'])->toDateTimeString();
        } else {
            $realtime = now()->toDateTimeString();
        }

            $hardware_data = Hardware_data::create([
                'hardware_id' => $hardware_id,
                'pm2_5' => $rawdata['pm2_5'] ?? null,
                'pm10' => $rawdata['pm10']?? null,
                'co' => $rawdata['co']?? null,
                'no2' => $rawdata['no2']?? null,
                'decibels' => $rawdata['decibels']?? null,
                'realtime_stamp' => $realtime?? null,
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
    return response()->noContent();
  }

}

<?php

namespace App\Http\Controllers;

use App\Models\History_status;
use App\Models\Pending_hardware_data;
use Exception;
use Illuminate\Http\Request;

class PendingHardwareDataController extends Controller
{

    public function index()
    {
       $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
       $pending_data = Pending_hardware_data::latest('pending_hardware_data_id') // or any ordering you need
            ->paginate(10);
       
        return view('admin.pending.admin_pending_data', compact('pending_data', 'notifs'));
    }

    public function store($pending_hardware_info, $pm2_5, $pm10, $co, $no2, $decibels, $realtime_stamp)
    {
        try{
        //$rawdata = $request->json()->all();

        // $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');
        //  if(empty($hardware_id)){

            
        //     return response()->json(['success' => true, 
        //     'hardware_info' => $rawdata['hardware_info'],
        //     'message' => 'Hardware ID not found, added to pending data.'], 200);
        //  }

            // $pending_hardware_data = Pending_hardware_data::create([
            //     'pending_hardware_info' => $rawdata['hardware_info'],
            //     'pm2_5' => $rawdata['pm2_5'] ?? null,
            //     'pm10' => $rawdata['pm10']?? null,
            //     'co' => $rawdata['co']?? null,
            //     'no2' => $rawdata['no2']?? null,
            //     'decibels' => $rawdata['decibels']?? null,
            //     'realtime_stamp' => $rawdata['realtime_stamp']?? null,
            // ]);

            $pending_hardware_data = Pending_hardware_data::create([
                'pending_hardware_info' => $pending_hardware_info,
                'pm2_5' => $pm2_5 ?? null,
                'pm10' => $pm10 ?? null,
                'co' => $co ?? null,
                'no2' => $no2 ?? null,
                'decibels' => $decibels ?? null,
                'realtime_stamp' => $realtime_stamp ?? null,
            ]);
            //pending data shouldnt alert users if the data is pending
            // if($hardware_data){
            //     $alertsController = new AlertsController();
            //     $alertsController->store($rawdata['pm2_5'], $rawdata['pm10'], $rawdata['co'], $rawdata["no2"], $rawdata["decibels"]);
            // }
    } catch (Exception $e) {
        return response()->json([
            'error'   => 'Server Error',
            'message' => $e->getMessage(),
            'trace'   => $e->getTrace()
        ], 500);
    }
    }

}

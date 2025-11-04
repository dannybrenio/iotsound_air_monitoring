<?php

namespace App\Http\Controllers;

use App\Events\SensorMalfunctioned;
use App\Models\Alerts;
use App\Models\History_status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AlertsController extends Controller
{

    public function index(){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

        $alerts = Alerts::paginate(5);
        return view('admin.alert.admin_alert', compact('alerts', 'notifs'));
    }

    public function store($aqiLevel, $hardwareIdentifyer){  

    $combined = $aqiLevel . " from " . $hardwareIdentifyer;
    $exists = Alerts::where('alert_body',$combined)
        ->where('created_at', '>=', Carbon::now()->subHours(3))
        ->exists();

        if ($exists) {
            return response()->json(['message' => 'Downtime!']); // still cooling down
        }

        Alerts::create([
             'alert_body' => $combined,
        ]);

        return response()->json(['message' => 'New ALert!']);
    }
    
    public function receiveSensorStatus(Request $request){
        $rawdata = $request->json()->all();

        SensorMalfunctioned::dispatch([
            "hardware_info" => $rawdata["hardware_info"],
            "sensor_type" => $rawdata["sensor_type"],
            "sensor_status" => $rawdata["sensor_status"]
        ]);    
        
        return response()->json(['message' => "Sensor status received :> yay"], 200);
        
    }    
}

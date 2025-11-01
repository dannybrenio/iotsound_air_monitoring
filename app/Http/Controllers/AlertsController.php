<?php

namespace App\Http\Controllers;

use App\Events\SensorMalfunctioned;
use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    
    public function index(){
        $alerts = Alerts::paginate(5);
        return view('admin.alert.admin_alert', compact('alerts'));
    }

    public function store($aqiLevel){  

        Alerts::create([
             'alert_body' => $aqiLevel,
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

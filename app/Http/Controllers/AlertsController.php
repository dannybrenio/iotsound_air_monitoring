<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    
    public function index(){
        $alerts = Alerts::all();
        return view('admin.alert.alert', compact('alerts'));
    }

    public function store($pm2_5_val, $pm10_val, $co_val, $no2_val, $decibels_val){   

        $pm2_5_str = '';
        $pm10_str = '';
        $co_str = '';
        $no2_str = '';
        $decibels_str = '';

        if($pm2_5_val > 69){
            if($pm2_5_val){

                $pm2_5_str = "";

            }elseif($pm2_5_str){

            }

        }

        if($pm10_val > 69){
            if($pm10_val){

                $pm10_str = "";

            }elseif($pm10_str){

            }
        }

        if($co_val > 69){
            if($co_val){

                $co_str = "";

            }elseif($co_str){

            }

        }
        
        if($no2_val){
            if($no2_val){
                $no2_str = "";
            }elseif($no2_val){
                $no2_str = "";
            }
        }    

        
        
        $complete_alert_string = $pm2_5_str . $pm10_str . $co_str;

 
        Alerts::create([
             'alert_body' => $complete_alert_string,
        ]);

        return response()->json(['message' => 'New ALert!']);
    }

    public function receiveSensorStatus(Request $request){
            
    }    
}

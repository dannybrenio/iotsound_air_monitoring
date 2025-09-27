<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    
    public function index()
    {
        $alerts = Alerts::all();
        return view('admin.alert.alert', compact('alerts'));
    }

    public function create()
    {
        // $alerts = Alerts::create($request->all());
        // return response()->json($alerts, 201);

        //six parameters then those six parameters have conditional levels accurding to standard
        //if theres a parameter its creates a string if no parameters are on alert it doest create it 
        // then sends the db the string stores it 
        // no alert head anymore
    }
        

    public function store()
    {   

        $para1 = 70;
        $para2 = 85;
        $para3 = 80;
        $parameter_one = '';
        $parameter_two = '';
        $parameter_three = '';

        if($para1 > 69){
            switch($para1){
                case 70:
                    $parameter_one = "This pm has reached a low level ";
                    break;
                case 80:
                    $parameter_one = "This pm has reached a middle level "; 
                    break;
                case 85:
                    $parameter_one = "This pm has reached a high level "; 
                    break;
            }
        }

               if($para2 > 69){
            switch($para2){
                case 70:
                    $parameter_two = "This co2 has reached a low level ";
                    break;
                case 80:
                    $parameter_two = "This co2 has reached a middle level "; 
                    break;
                case 85:
                    $parameter_two = "This co2 has reached a high level "; 
                    break;
            }
        }
                if($para3 > 69){
            switch($para3){
                case 70:
                    $parameter_three = "This co has reached a low level";
                    break;
                case 80:
                    $parameter_three = "This co has reached a middle level"; 
                    break;
                case 85:
                    $parameter_three = "This co has reached a high level"; 
                    break;
            }
        }

        $complete_alert_string = $parameter_one . $parameter_two . $parameter_three;

 
        ALerts::create([
             'alert_body' => $complete_alert_string,
        ]);

        return response()->json(['message' => 'New ALert!']);
    }

    public function show(Alerts $alerts)
    {
        //
    }

    public function edit(Alerts $alerts)
    {
        //
    }

    public function update(Request $request, Alerts $alerts)
    {
        //
    }

    public function destroy(Alerts $alerts)
    {
        //
    }
}

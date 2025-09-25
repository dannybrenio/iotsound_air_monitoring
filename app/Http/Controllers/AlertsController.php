<?php

namespace App\Http\Controllers;

use App\Models\Alerts;
use Illuminate\Http\Request;

class AlertsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alerts = Alerts::all();
        return view('admin.alert.alert', compact('alerts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $alerts = Alerts::create($request->all());
        // return response()->json($alerts, 201);

        //six parameters then those six parameters have conditional levels accurding to standard
        //if theres a parameter its creates a string if no parameters are on alert it doest create it 
        // then sends the db the string stores it 
        // no alert head anymore
    }

    /**
     * Store a newly created resource in storage.
     */
     
        

    public function store()
    {   
        $parameter_one = '';
        $parameter_two = '';
        $parameter_three = '';

        if(1 != 1){
            
            $parameter_one = 'check1';
        }

          if(1 != 2){
            
            $parameter_two = 'check2';
        }
          if(1 != 3){
            
            $parameter_three = 'check3';
        }


        $complete_alert_string = $parameter_one + $parameter_two + $parameter_three;
 
        ALerts::create([
             'alert_body' => $complete_alert_string,
        ]);

        return response()->json(['message' => 'New ALert!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Alerts $alerts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alerts $alerts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alerts $alerts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alerts $alerts)
    {
        //
    }
}

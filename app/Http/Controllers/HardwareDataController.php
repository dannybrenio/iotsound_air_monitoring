<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Http\Controllers\AlertsController;
use Illuminate\Http\Request;

class HardwareDataController extends Controller
{

       public function index()
    {
        $hardware_data = Hardware_data::all();
        return view('admin.hardware.hardware_data', compact('hardware_data'));
    }
  

 public function receiveData(Request $request){

        $rawdata = $request->json()->all();

        //dd($rawdata);
        $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');
         if(!empty($hardware_id)){

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
                //dd($rawdata['pm2_5'], $rawdata['pm10'], $rawdata['no2']);
                   //store($rawdata['pm2_5'], $rawdata['pm10'], $rawdata['no2']);         
                   //store(70,80,60);
                   $alertsController = new AlertsController();
                   $alertsController->store($rawdata['pm2_5'], $rawdata['pm10'], $rawdata['co'] );
                }
        }else{
            dd('does not exist');
        }
    //    no return response here 
    }



    public function receiveData2(Request $request)
{
    try {
        $rawdata = $request->json()->all();

        // Check the received data
        if (empty($rawdata)) {
            return response()->json(['error' => 'Empty JSON received'], 400);
        }

        // Find hardware_id
        $hardware_id = Hardware::where('hardware_info', $rawdata['hardware_info'])->value('hardware_id');

        if (!$hardware_id) {
            return response()->json(['error' => 'Hardware not found'], 404);
        }

        // Insert into database
        $hardware_data = Hardware_data::create([
            'hardware_id'    => $hardware_id,
            'pm2_5'          => $rawdata['pm2_5'] ?? null,
            'pm10'           => $rawdata['pm10'] ?? null,
            'co'             => $rawdata['co'] ?? null,
            'no2'            => $rawdata['no2'] ?? null,
            'decibels'       => $rawdata['decibels'] ?? null,
            'realtime_stamp' => $rawdata['realtime_stamp'] ?? now(),
        ]);

        return response()->json([
            'message' => 'Data inserted successfully',
            'data'    => $hardware_data
        ], 201);

    } catch (\Exception $e) {
        // Catch and return error in JSON
        return response()->json([
            'error'   => 'Server Error',
            'message' => $e->getMessage(),
            'trace'   => $e->getTrace()
        ], 500);
    }
}





    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }


    public function show(Hardware_data $hardware_data)
    {
        //
    }


    public function edit(Hardware_data $hardware_data)
    {
        //
    }


    public function update(Request $request, Hardware_data $hardware_data)
    {
        //
    }

 
    public function destroy(Hardware_data $hardware_data)
    {
        //
    }
}

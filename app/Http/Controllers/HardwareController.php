<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Models\Pending_hardware;
use App\Models\Pending_hardware_data;
use App\Models\Device_status;
use Illuminate\Http\Request;

class HardwareController extends Controller
{

    public function index(){
        $hardwares = Hardware::all();
        return view('admin.hardware.hardware', compact('hardwares'));
    }

    public function create(){
        $pending_list = Pending_hardware::all(); 
        return view('admin.hardware.hardware_create', compact('pending_list'));
    }

    public function store(Request $request){

        $pending = Pending_hardware::findOrFail($request->hardware_info);

        $insertedData = [];

            $hardwareInfo = $pending->hardware_info;
            $latitude = $pending->latitude;
            $longitude = $pending->longitude;

        //still undecided to the status logic
           $hardware_created = Hardware::create([
                'hardware_info' => $hardwareInfo,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'status' => 'active', 
            ]);

            if($hardware_created){
                Device_status::create([
                    'hardware_info' => $hardwareInfo,
                    'pms_status' => 'active',
                    'mq135_status' => 'active',
                    'mq7_status' => 'active',
                    'sound_status' => 'active',
                    'timestamp_status' => 'active',
                ]);
            }
            
            $hardware_id_fetch = $hardware_created->hardware_id;

               $pending_data_fetch= Pending_hardware_data::where('pending_hardware_info', $hardwareInfo)->get();

                foreach ($pending_data_fetch as $pending_fetch) {
                $newData = $pending_fetch->toArray();
                $newData['hardware_id'] = $hardware_id_fetch; // assign foreign key
                $record = Hardware_data::create($newData);

               // $insertedData[] = $record;
    }
                //    return response([
                //     'inserted_count' => count($insertedData),
                //     'inserted_data' => $insertedData,
                // ], 200);

                Pending_hardware_data::where('pending_hardware_info', $hardwareInfo)->delete();
                $pending->delete();
                return redirect()->route('hardware.index')->with('success', 'Device registered successfully!');
        }

    public function edit($hardware_id){
        $hardware = Hardware::findOrFail($hardware_id);
        return view('admin.hardware.hardware_update', compact('hardware'));
    }

    public function update(Request $request, $hardware_id){   
        $validated = $request->validate([
        'hardware_info' => 'required',
        'hardware_location' => 'required',
    ]);

        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->update($validated);
        return redirect()->route('hardware.index')->with('success', 'Device updated successfully!');
    }
    

    public function destroy($hardware_id){
        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->delete();
        return redirect()->route('hardware.index')->with('success', 'Device unregistered successfully!');
    }

    public function receiveHardware(Request $request){
        $validated = $request->validate([
         'hardware_info' => 'required',
         'latitude' => 'required',
         'longitude' => 'required',
        ]);
       $hardware = Hardware::where('hardware_info', $validated['hardware_info'])->first();

       if(!$hardware){
            Pending_hardware::updateOrCreate(
            ['hardware_info' => $validated['hardware_info']], // Search condition
            [
                'latitude' => $validated['latitude'], //replaced values
                'longitude' => $validated['longitude']
            ]
            );
       }  
    }
}

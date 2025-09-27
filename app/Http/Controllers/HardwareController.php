<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Pending_hardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{

    public function index()
    {
        $hardwares = Hardware::all();
        return view('admin.hardware.hardware', compact('hardwares'));
    }

    public function create()
    {
        $pending_list = Pending_hardware::all(); 
        return view('admin.hardware.hardware_create', compact('pending_list'));
    }

    public function store(Request $request)
    {

 $pending = Pending_hardware::findOrFail($request->hardware_info);

   
    $hardwareInfo = $pending->hardware_info;
    $latitude = $pending->latitude;
    $longitude = $pending->longitude;

   //dd($hardwareInfo, $latitude, $longitude);

   //still undecided to the status logic
    Hardware::create([
        'hardware_info' => $hardwareInfo,
        'longitude' => $longitude,
        'latitude' => $latitude,
        'status' => 'active', 
    ]);

        //deletes the data on the device if done
          $pending->delete();
        return redirect()->route('hardware.index')->with('success', 'Device registered successfully!');
    }

    public function show(Hardware $hardware)
    {
       
    }

    public function edit($hardware_id)
    {
        $hardware = Hardware::findOrFail($hardware_id);
        return view('admin.hardware.hardware_update', compact('hardware'));
    }

    public function update(Request $request, $hardware_id)
    {   
        //dd($hardware_id);

            $validated = $request->validate([
            'hardware_info' => 'required',
            'hardware_location' => 'required',
        ]);
        
        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->update($validated);
            return redirect()->route('hardware.index')->with('success', 'Device updated successfully!');
    }
    

    public function destroy($hardware_id)
    {
        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->delete();

        return redirect()->route('hardware.index')->with('success', 'Device unregistered successfully!');
    }

    public function receiveHardware(Request $request){
       //dd('hehe');
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
       // no return response here 
    }
}

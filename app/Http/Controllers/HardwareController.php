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
        return view('admin.hardware.hardware_create');
    }

    public function store(Request $request)
    {
         $validated = $request->validate([
            'hardware_info' => 'required',
            'hardware_location' => 'required',
        ]);
 
        Hardware::create($validated);
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
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude']
            ]
            );
       }  
       // no return response here hehe
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Hardware_data;
use App\Models\Pending_hardware;
use App\Models\Pending_hardware_data;
use App\Models\Device_status;
use App\Models\History_status;
use Illuminate\Http\Request;

class HardwareController extends Controller
{

    public function index(){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        $hardwares = Hardware::paginate(10);
        $pending_hardwares = Pending_hardware::all();
            
        return view('admin.hardware.admin_hardware', compact('hardwares', 'pending_hardwares', 'notifs'));
    }

    public function create(){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        $pending_list = Pending_hardware::all(); 
        return view('admin.hardware.hardware_create', compact('pending_list', 'notifs'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'hardware_info' => 'required|string',
        ]);
    
        $pending = Pending_hardware::where('hardware_info', $request->hardware_info)->firstOrFail();
    
        
        $hardwareInfo  = $pending->hardware_info;
        $locationName  = $pending->location_name;
        $latitude      = $pending->latitude;
        $longitude     = $pending->longitude;
        
        $hardware_created = Hardware::create([
            'hardware_info'  => $hardwareInfo,
            'location_name'  => $locationName,
            'longitude'      => $longitude,
            'latitude'       => $latitude,
            'status'         => 'active'
        ]);
    
        if ($hardware_created) {
            Device_status::create([
                'hardware_info'      => $hardwareInfo,
                'pms_status'         => 'active',
                'mq135_status'       => 'active',
                'mq7_status'         => 'active',
                'sound_status'       => 'active',
                'timestamp_status'   => 'active',
            ]);
        }
    
        $hardware_id_fetch = $hardware_created->hardware_id;
    
        $pending_data_fetch = Pending_hardware_data::where('pending_hardware_info', $hardwareInfo)->get();
    
        foreach ($pending_data_fetch as $pending_fetch) {
            $newData = $pending_fetch->toArray();
    
            unset($newData['id']);
    
            $newData['hardware_id'] = $hardware_id_fetch;
    
            Hardware_data::create($newData);
        }
    
        Pending_hardware_data::where('pending_hardware_info', $hardwareInfo)->delete();
        $pending->delete();
    
        return redirect()->route('hardware')->with('success', 'Device registered successfully!');
    }

    public function edit($hardware_id){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        $hardware = Hardware::findOrFail($hardware_id);
        return view('admin.hardware.hardware_update', compact('hardware', 'notifs'));
    }

    public function update(Request $request, $hardware)
    {
        $validated = $request->validate([
            'hardware_info' => 'required|string',
            'location_name' => 'required|string',
            'longitude'     => 'required',
            'latitude'      => 'required',
        ]);
    
        $hw = Hardware::where('hardware_id', $hardware)->firstOrFail();
        $hw->update($validated);
    
        return redirect()->route('hardware')->with('success', 'Hardware updated successfully!');
    }

    public function destroy($hardware_id){
        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->delete();
        return redirect()->route('hardware')->with('success', 'Device unregistered successfully!');
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

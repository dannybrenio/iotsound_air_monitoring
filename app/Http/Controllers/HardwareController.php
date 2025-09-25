<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hardwares = Hardware::all();
        return view('admin.hardware.hardware', compact('hardwares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hardware.hardware_create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($hardware_id)
    {
        $hardware = Hardware::findOrFail($hardware_id);
        return view('admin.hardware.hardware_update', compact('hardware'));
    }

    /**
     * Update the specified resource in storage.
     */
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
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($hardware_id)
    {
        $hardware = Hardware::findOrFail($hardware_id);
        $hardware->delete();

        return redirect()->route('hardware.index')->with('success', 'Device unregistered successfully!');
    }
}

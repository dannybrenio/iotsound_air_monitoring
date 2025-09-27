<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use Illuminate\Http\Request;

class HardwareDataController extends Controller
{

       public function index()
    {
        $hardware_data = Hardware_data::all();
        return view('admin.hardware.hardware_data', compact('hardware_data'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Device_status;
use Illuminate\Http\Request;

class DeviceStatusController extends Controller
{
    public function index()
    {
       $device_statuses = Device_status::all();
       return view('admin.status.device_status', compact('device_statuses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(Device_status $device_status)
    {
        //
    }

    public function update(Request $request, Device_status $device_status)
    {
        //
    }

    public function destroy(Device_status $device_status)
    {
        //
    }
}

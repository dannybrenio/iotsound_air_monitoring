<?php

namespace App\Http\Controllers;

use App\Models\Device_status;
use Illuminate\Http\Request;

class DeviceStatusController extends Controller
{
    public function index()
    {
       $device_statuses = Device_status::all();
       return view('admin.device_status.admin_device_status', compact('device_statuses'));
    }

    public function update(Request $request, Device_status $device_status)
    {
        //
    }

}

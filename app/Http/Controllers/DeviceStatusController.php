<?php

namespace App\Http\Controllers;

use App\Models\Device_status;
use App\Models\History_status;
use Illuminate\Http\Request;

class DeviceStatusController extends Controller
{
    public function index()
    {
       $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();

       $device_statuses = Device_status::latest('status_id') // or any ordering you need
            ->paginate(10);
       return view('admin.device_status.admin_device_status', compact('device_statuses', 'notifs'));
    }

    public function update(Request $request, Device_status $device_status)
    {
        //
    }

}

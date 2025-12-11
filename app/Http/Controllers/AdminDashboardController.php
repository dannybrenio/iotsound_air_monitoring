<?php

namespace App\Http\Controllers;
use App\Models\Device_status;
use App\Models\History_status;
use App\Models\User;
use App\Models\Report;
use App\Models\Alerts;
use illuminate\http\Request;

use Carbon\Carbon;
class AdminDashboardController extends Controller
{
    public function index(){
        $notifs = History_status::where('isRead', 0)->orderByDesc('created_at')->get();
        $device_statuses = Device_status::latest('status_id')->get();
        $users = User::latest('id')->get(); // or any ordering you need
        $reports = Report::whereDate('created_at', Carbon::today())->count();
        $alerts = Alerts::whereDate('created_at', Carbon::today())->count();
        return view('admin.dashboard.admin_dashboard', compact( 'device_statuses' , 'notifs', 'users', 'reports','alerts'));
    }
}
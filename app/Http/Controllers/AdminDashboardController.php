<?php

namespace App\Http\Controllers;
use App\Models\Device_status;
use App\Models\History_status;
use App\Models\User;
use App\Models\Report;
use App\Models\Alerts;
use App\Services\AqiCalculator;
use illuminate\http\Request;
use App\Models\Hardware_data;
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
    
    public function latest(AqiCalculator $aqiService)
    {
        $now = Carbon::now(config('app.timezone', 'Asia/Manila'));
    
        $since12h = $now->copy()->subHours(12);
    
        $data = Hardware_data::whereBetween('realtime_stamp', [$since12h, $now])
            ->orderBy('realtime_stamp')
            ->get();
    
        if ($data->isEmpty()) {
            return response()->json(null);
        }
    
        // ✅ Use your service
        $nowcast = $aqiService->computeNowCast($data);
    
        $latestRow = $data->last();
    
        return response()->json([
            'aqi'       => $nowcast['overall_aqi'] ?? null,
            'decibel'   => $latestRow->decibels ?? null,
            'datetime'  => $latestRow->realtime_stamp,
        ]);
    }

}
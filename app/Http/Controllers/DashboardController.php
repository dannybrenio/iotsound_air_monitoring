<?php

namespace App\Http\Controllers;

use App\Models\HardwareDataController;
use App\Events\ReadingReceived;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Just supply your own static data
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        $readings = [
                        ["pm 2.5" => 12, "pm 10" => 15, "co" => 18, "no2" => 23],
                        ["pm 2.5" => 32, "pm 10" => 45, "co" => 25, "no2" => 13],
                        ["pm 2.5" => 56, "pm 10" => 25, "co" => 58, "no2" => 43],
                    ];

        return view('dashboard', compact('months', 'readings'));
    }

    public function sendReading(Request $request){
        ReadingReceived::dispatch($request);
        
        // return response()->json(['ok' => true]);
    }

    public function receiveSensorStatus(Request $request){
        // Log::info('POST /api/readings payload', ['body' => $request->all()]);

        // $data = $request->validate([
        //     'deviceId'     => 'required|string|max:64',
        //     'pm2_5'        => 'nullable|numeric',
        //     'pm10'         => 'nullable|numeric',
        //     'temp_c'       => 'nullable|numeric',
        //     'rh'           => 'nullable|numeric',
        //     'noise_leq_db' => 'nullable|numeric',
        // ]);
    }
}

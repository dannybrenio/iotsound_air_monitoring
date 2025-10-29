<?php

namespace App\Http\Controllers;

use App\Models\HardwareDataController;
use App\Events\ReadingReceived;
use App\Models\Hardware_data;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $months = ['Jan','Feb','Mar','Apr','May']; 
        $readings = Hardware_data::query()
            ->orderBy('created_at')        
            ->select([
                'hardware_id',
                'pm2_5',     
                'pm10',      
                'co',     
                'no2',        
                'decibels',    
                'realtime_stamp',
            ])
            ->take(200)                       
            ->get();

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

<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use App\Services\AqiCalculator;
use Carbon\Carbon;
use App\Models\HardwareDataController;
use App\Events\ReadingReceived;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(AqiCalculator $aqiCalculator){

        $data = $aqiCalculator->compute();
        $individualdata = Hardware_data::latest()->first();

        $today = Carbon::today();
        $peakDecibels = Hardware_data::whereDate('created_at', $today)->max('decibels');
        $overallNowcast = $data['overall']['nowcast'];

        //$overallNowcast = data_get($data, 'overall.nowcast');
       // $individualArr = $individualdata?->only(['id','pm25','decibels','created_at']);

        return view('front.dashboard', compact(
        'data',
        'individualdata',
        'overallNowcast',
        'peakDecibels'
    ));

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

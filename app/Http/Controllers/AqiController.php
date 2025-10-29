<?php

namespace App\Http\Controllers;

use App\Models\Hardware_data;
use App\Services\AqiCalculator;
use Carbon\Carbon;

class AqiController extends Controller
{
    public function index(AqiCalculator $aqiCalculator)
    {
        $data = $aqiCalculator->compute();
        $individualdata = Hardware_data::latest()->first();

        $today = Carbon::today();
        $peakDecibels = Hardware_data::whereDate('created_at', $today)->max('decibels');
        //$overallNowcast = $data['overall']['nowcast'];

        $overallNowcast = data_get($data, 'overall.nowcast');
        $individualArr = $individualdata?->only(['id','pm25','decibels','created_at']);



    return view('front.dashboard', compact(
        'data',
        'overallNowcast',
        'peakDecibels'
    ) + ['individualdata' => $individualArr]);

        // return view('front.dashboard', [
        //  'data' => $data,
        //  'overallNowcast' => $overallNowcast,
        //  'individualdata' => $individualdata,
        //  'peakDecibels' => $peakDecibels
        // ]);
    }




}

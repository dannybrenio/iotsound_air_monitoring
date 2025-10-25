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

        return view('testing', [
         'data' => $data,
         'individualdata' => $individualdata,
         'peakDecibels' => $peakDecibels
        ]);
    }




}

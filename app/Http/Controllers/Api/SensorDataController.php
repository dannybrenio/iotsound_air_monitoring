<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FCMv1Controller;
use App\Models\Hardware_data;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    public function index()
    {
        // return latest N readings (adjust fields to your table)
        $readings = Hardware_data::orderBy('created_at', 'desc')
            ->limit(50)
            ->get(['hardware_id','pm2_5','pm10','co','no2','decibels','realtime_stamp']);

        return response()->json([
            'data' => $readings->reverse()->values(), // oldest→newest for charts
        ]);
    }

    public function latest()
    {
        $reading = Hardware_data::orderBy('created_at', 'desc')
            ->first(['hardware_id','pm2_5','pm10','co','no2','decibels','realtime_stamp']);

        return response()->json(['data' => $reading]);
    }
}

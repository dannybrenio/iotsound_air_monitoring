<?php

namespace App\Http\Controllers;

use App\Services\AqiCalculator;

class AqiController extends Controller
{
    public function index(AqiCalculator $aqiCalculator)
    {
        $data = $aqiCalculator->compute();

        return view('testing', ['data' => $data]);
    }
}

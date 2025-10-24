<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Pwd na tanggalin for checking of values onle
Route::get('/weather', function (Request $request) {
    $city = $request->query('city', 'Caloocan');
    $coords = [
        'Caloocan' => ['lat' => 14.65, 'lon' => 120.97],
    ];
    $lat = $coords[$city]['lat'] ?? 14.65;
    $lon = $coords[$city]['lon'] ?? 120.97;

    $response = Http::get("https://api.open-meteo.com/v1/forecast", [
        'latitude' => $lat,
        'longitude' => $lon,
        'daily' => 'temperature_2m_max,temperature_2m_min,weathercode',
        'current_weather' => true,
        'timezone' => 'auto',
    ]);

    return response()->json($response->json());
});

// Pwd na tanggalin
Route::get('/weather1', function (Request $request) {
    $city = $request->query('city', 'Caloocan');
    $apiKey = env('WEATHER_KEY');

    $response = Http::get("https://api.weatherapi.com/v1/forecast.json", [
        'key' => $apiKey,
        'q' => $city,
        'days' => 7,
        'aqi' => 'no',
        'alerts' => 'no',
    ]);

    return response()->json($response->json());
});


Route::post('/send-reading', [DashboardController::class, 'sendReading'])->name('send.reading');

Route::post('/sensor-status', [DashboardController::class, 'receiveSensorStatus'])->name('sensor-status');

Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');
 Route::Post('receive_hardware', [HardwareController::class, 'receiveHardware'])->name('hardware.receive');
Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');


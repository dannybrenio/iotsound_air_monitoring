<?php

use App\Http\Controllers\AlertsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;
use App\Http\Controllers\HistoryStatusController;
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


// Route::post('/send-reading', function (Request $request) {
//     $reading = new \App\Models\Hardware_data([
//         'hardware_id'    => 1,
//         'pm2_5'          => null,
//         'pm10'           => null,
//         'co'             => null,
//         'no2'            => null,
//         'decibels'       => null,
//         'realtime_stamp' => now(),
//     ]);
//     event(new ReadingReceived($reading));
//     return response()->noContent();
// });

Route::post('/sensor-status', [AlertsController::class, 'receiveSensorStatus'])->name('sensor-status');

//Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');
Route::Post('receive_hardware', [HardwareController::class, 'receiveHardware'])->name('hardware.receive');
Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');
Route::Post('receive_status', [HistoryStatusController::class, 'receiveStatus'])->name('hardware.receive_status');



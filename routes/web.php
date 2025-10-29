<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeviceStatusController;
use App\Http\Controllers\HistoryStatusController;

use App\Http\Controllers\AqiController;
use App\Http\Controllers\ExportController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', function () { return view('about'); })->name('about');;
Route::get('/help', function () { return view('help'); })->name('help');;
Route::get('/weather', function () { return view('weather'); });
// Route::get('/', function () {
//     return view('index');
// });

Route::prefix('admin')->group(function () {
    Route::resource('hardware', HardwareController::class);
    Route::resource('hardware_data', HardwareDataController::class);
    Route::resource('alert', AlertsController::class);
    Route::resource('report', ReportController::class);
    Route::resource('device_status', DeviceStatusController::class);
    Route::resource('history_status', HistoryStatusController::class);
});

// Route::get('testing', function(){
//     return view('testing');
// });

Route::get('/testing', [AqiController::class, 'index']);
//  Route::post('receive_hardware', [HardwareController::class, 'receiveHardware'])->name('hardware.receive');
//  Route::Post('receive-data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');

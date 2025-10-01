<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;

Route::post('/send-reading', [DashboardController::class, 'sendReading'])->name('send.reading');

Route::post('/sensor-status', [DashboardController::class, 'receiveSensorStatus'])->name('sensor-status');

Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');


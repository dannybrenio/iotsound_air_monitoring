<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::post('/send-reading', [DashboardController::class, 'sendReading'])->name('send.reading');

Route::post('/sensor-status', [DashboardController::class, 'receiveSensorStatus'])->name('sensor-status');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;
use App\Http\Controllers\PendingHardwareController;
use App\Http\Controllers\PendingHardwareDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DeviceStatusController;
use App\Http\Controllers\HistoryStatusController;
use App\Http\Controllers\AqiController;

// Dashboard
//Route::get('/', function () { return view('front.dashboard'); })->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', function () { return view('front.about'); })->name('about');;
Route::get('/help', function () { return view('front.help'); })->name('help');;
Route::get('/weather', function () { return view('weather'); });

// Route::get('/testing', [AqiController::class, 'index']);

//  Route::post('receive_hardware', [HardwareController::class, 'receiveHardware'])->name('hardware.receive');
//  Route::Post('receive-data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');

// Log in
Route::get('/admin', function () { return view('login');})->name('login');;

// Admin
Route::get('/admin_hardware', [HardwareController::class, 'index'])->name('hardware');
Route::get('/admin_hardware_data', [HardwareDataController::class, 'index'])->name('hardwareData');
Route::get('/admin_pending_data', [PendingHardwareDataController::class, 'index'])->name('pendingData');
Route::get('/admin_pending_hardware', [PendingHardwareController::class, 'index'])->name('pendingHardware');
Route::get('/admin_report', [ReportController::class, 'index'])->name('report');
Route::get('/admin_account', function () {return view('admin.account.admin_account');})->name('account');;
Route::get('/admin_alert', [AlertsController::class, 'index'])->name('alert');
Route::get('/admin_device_status', [DeviceStatusController::class, 'index'])->name('device');
Route::get('/admin_history_status', [HistoryStatusController::class, 'index'])->name('history');

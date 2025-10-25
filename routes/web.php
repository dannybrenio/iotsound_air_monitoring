<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\HardwareDataController;
use App\Http\Controllers\ReportController;

// Dashboard
Route::get('/', function () { return view('front.dashboard'); })->name('dashboard');
Route::get('/about', function () { return view('front.about'); })->name('about');;
Route::get('/help', function () { return view('front.help'); })->name('help');;
Route::get('/weather', function () { return view('weather'); });

// Log in
Route::get('/login', function () { return view('login');})->name('login');;
// Route::get('/admin', function () { return view('components.admin');})->name('admin');;

// Admin
Route::get('/admin_hardware', function () {return view('admin.hardware.admin_hardware');})->name('hardware');;
Route::get('/admin_hardware_data', function () {return view('admin.hardware.admin_hardware_data');})->name('hardwareData');;
Route::get('/admin_pending_hardware', function () {return view('admin.pending.admin_pending_hardware');})->name('pendingHardware');;
Route::get('/admin_pending_data', function () {return view('admin.pending.admin_pending_data');})->name('pendingData');;
Route::get('/admin_report', function () {return view('admin.report.admin_report');})->name('report');;
Route::get('/admin_account', function () {return view('admin.account.admin_account');})->name('account');;
Route::get('/admin_alert', function () {return view('admin.alert.admin_alert');})->name('alert');;


// Route::get('/', function () {
//     return view('index');
// });

Route::prefix('admin')->group(function () {
    Route::resource('hardware', HardwareController::class);
    Route::resource('hardware_data', HardwareDataController::class);
    Route::resource('alert', AlertsController::class);
    Route::resource('report', ReportController::class);
   
});

 Route::post('receive_hardware', [HardwareController::class, 'receiveHardware'])->name('hardware.receive');
 Route::Post('receive_data', [HardwareDataController::class, 'receiveData'])->name('hardware.receive_data');

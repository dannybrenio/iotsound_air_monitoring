<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

// ======================
// Public Routes
// ======================

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', fn() => view('front.about'))->name('about');
Route::get('/help', fn() => view('front.help'))->name('help');
Route::get('/weather', fn() => view('weather'));

// ======================
// Login & Logout
// ======================

Route::get('/admin', function () {
    if(Session::get('logged_in')){
        return redirect()->route('hardware');
    }
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Hardcoded credentials
    if ($username === 'admin' && $password === 'admin') {
        Session::put('logged_in', true);
        return redirect()->route('hardware');
    }

    return back()->with('error', 'Invalid username or password');
})->name('login.post');

Route::get('/logout', function () {
    Session::forget('logged_in');
    return redirect()->route('dashboard');
})->name('logout');

// ======================
// Protected Admin Routes
// ======================

// Define a custom middleware inline
$authMiddleware = function (Request $request, \Closure $next) {
    if (!Session::get('logged_in')) {
        return redirect()->route('login');
    }
    return $next($request);
};

// Apply the middleware group properly
Route::middleware('auth.admin')->group(function () {
    Route::get('/admin_hardware', [HardwareController::class, 'index'])->name('hardware');
    Route::get('/admin_hardware_data', [HardwareDataController::class, 'index'])->name('hardwareData');
    Route::get('/admin_pending_data', [PendingHardwareDataController::class, 'index'])->name('pendingData');
    Route::get('/admin_pending_hardware', [PendingHardwareController::class, 'index'])->name('pendingHardware');
    Route::get('/admin_report', [ReportController::class, 'index'])->name('report');
    Route::get('/admin_account', fn() => view('admin.account.admin_account'))->name('account');
    Route::get('/admin_alert', [AlertsController::class, 'index'])->name('alert');
    Route::get('/admin_device_status', [DeviceStatusController::class, 'index'])->name('device');
    Route::get('/admin_history_status', [HistoryStatusController::class, 'index'])->name('history');
});

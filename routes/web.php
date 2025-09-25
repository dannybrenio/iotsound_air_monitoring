<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;

Route::get('/', function () {
    return view('index');
});



Route::prefix('admin')->group(function () {
    Route::resource('hardware', HardwareController::class);
    Route::resource('alert', AlertsController::class);
});


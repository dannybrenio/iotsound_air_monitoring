<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertsController;
use App\Http\Controllers\HardwareController;

Route::prefix('admin')->group(function () {
    Route::apiResource('hardware', HardwareController::class);
    Route::apiResource('alert', AlertsController::class);
});

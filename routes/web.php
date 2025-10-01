<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', function () { return view('about'); })->name('about');;
Route::get('/help', function () { return view('help'); })->name('help');;
Route::get('/weather', function () { return view('weather'); });


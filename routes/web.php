<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'] )->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    // TODO: Profile
    Route::resource('cities', CityController::class)->only(['index', 'show']);
});

Auth::routes();

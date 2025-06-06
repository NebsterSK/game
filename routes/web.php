<?php

use App\Http\Controllers\ColonyController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'] )->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    // TODO: Profile
    Route::resource('colonies', ColonyController::class)->only(['index', 'show']);
});

Auth::routes();

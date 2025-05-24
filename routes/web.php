<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 1;
})->name('home');

Route::get('/game', [GameController::class, 'index']);


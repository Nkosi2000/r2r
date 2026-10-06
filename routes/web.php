<?php

use App\Http\Controllers\R2rBotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/r2rbot', R2rBotController::class)
    ->middleware('throttle:r2rbot')
    ->name('r2rbot.chat');

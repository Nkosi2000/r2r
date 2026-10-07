<?php

use App\Http\Controllers\R2rBotController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/who-we-are', 'pages.about')->name('about');
Route::view('/what-we-do', 'pages.what-we-do')->name('what-we-do');
Route::view('/our-partners', 'pages.partners')->name('partners');
Route::view('/media', 'pages.media')->name('media');
Route::view('/events', 'pages.events')->name('events');
Route::view('/resources', 'pages.resources')->name('resources');
Route::view('/reports', 'pages.reports')->name('reports');
Route::view('/contact-us', 'pages.contact')->name('contact');

Route::post('/r2rbot', R2rBotController::class)
    ->middleware('throttle:r2rbot')
    ->name('r2rbot.chat');

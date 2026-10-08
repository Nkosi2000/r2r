<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\EventController;
use App\Http\Controllers\R2rBotController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/who-we-are', 'pages.about')->name('about');
Route::view('/what-we-do', 'pages.what-we-do')->name('what-we-do');
Route::view('/our-partners', 'pages.partners')->name('partners');
Route::view('/media', 'pages.media')->name('media');
Route::get('/events', EventController::class)->name('events');
Route::view('/resources', 'pages.resources')->name('resources');
Route::view('/reports', 'pages.reports')->name('reports');
Route::view('/contact-us', 'pages.contact')->name('contact');

Route::post('/r2rbot', R2rBotController::class)
    ->middleware('throttle:r2rbot')
    ->name('r2rbot.chat');

/*
|--------------------------------------------------------------------------
| CMS
|--------------------------------------------------------------------------
|
| Staff sign in at /admin/login. Sign-in and password reset keep Laravel's
| standard route names so the auth middleware and reset emails find them.
|
*/

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Admin\Auth\LoginController::class, 'create'])->name('login');
        Route::post('login', [Admin\Auth\LoginController::class, 'store'])->middleware('throttle:cms-login')->name('login.store');
        Route::get('forgot-password', [Admin\Auth\PasswordResetController::class, 'request'])->name('password.request');
        Route::post('forgot-password', [Admin\Auth\PasswordResetController::class, 'email'])->middleware('throttle:cms-login')->name('password.email');
        Route::get('reset-password/{token}', [Admin\Auth\PasswordResetController::class, 'edit'])->name('password.reset');
        Route::post('reset-password', [Admin\Auth\PasswordResetController::class, 'update'])->name('password.update');
    });

    Route::middleware('auth')->name('admin.')->group(function () {
        Route::post('logout', [Admin\Auth\LoginController::class, 'destroy'])->name('logout');

        Route::get('/', Admin\DashboardController::class)->name('dashboard');
        Route::get('profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

        Route::resource('pillars', Admin\PillarController::class)->except('show');
        Route::resource('programmes', Admin\ProgrammeController::class)->except('show');
        Route::resource('partners', Admin\PartnerController::class)->except('show');
        Route::resource('events', Admin\EventController::class)->except('show');
        Route::resource('media', Admin\MediaItemController::class)->except('show')->parameters(['media' => 'mediaItem']);
        Route::resource('resources', Admin\ResourceLinkController::class)->except('show')->parameters(['resources' => 'resourceLink']);
        Route::resource('reports', Admin\ReportController::class)->except('show');

        Route::post('reorder/{type}/{id}/{direction}', Admin\ReorderController::class)
            ->whereIn('type', array_keys(Admin\ReorderController::MODELS))
            ->whereNumber('id')
            ->whereIn('direction', ['up', 'down'])
            ->name('reorder');

        Route::middleware('can:manage-staff')->group(function () {
            Route::resource('users', Admin\UserController::class)->except('show');
        });

        Route::middleware('can:manage-settings')->group(function () {
            Route::get('settings', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
            Route::put('settings/about', [Admin\SettingsController::class, 'updateAbout'])->name('settings.about');
            Route::put('settings/contact', [Admin\SettingsController::class, 'updateContact'])->name('settings.contact');
            Route::put('settings/seo', [Admin\SettingsController::class, 'updateSeo'])->name('settings.seo');
            Route::put('settings/social', [Admin\SettingsController::class, 'updateSocial'])->name('settings.social');
        });
    });
});

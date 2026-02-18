<?php

use App\Http\Controllers\GuestEventRegistrationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 */

Route::get('/', function () {
    if (auth()->check() && auth()->user() instanceof User) {
        return redirect()->route(auth()->user()->dashboardRoute());
    }
    return view('welcome');
});

Route::get('/events/{event}/register', [GuestEventRegistrationController::class, 'create'])->name('events.guest.register');
Route::post('/events/{event}/register', [GuestEventRegistrationController::class, 'store'])->name('events.guest.store');

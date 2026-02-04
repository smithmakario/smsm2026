<?php

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

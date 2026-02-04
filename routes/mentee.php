<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mentee\MenteeDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('mentee.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:mentee'])->group(function () {
    Route::get('', MenteeDashboardController::class)->name('mentee.index');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('mentee.logout');
});

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('mentor.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:mentor'])->group(function () {
    Route::get('', MentorDashboardController::class)->name('mentor.index');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('mentor.logout');
});

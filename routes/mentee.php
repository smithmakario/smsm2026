<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mentee\MenteeDashboardController;
use App\Http\Controllers\Mentee\MenteePageController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('mentee.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:mentee'])->group(function () {
    Route::get('', MenteeDashboardController::class)->name('mentee.index');
    Route::get('journey', [MenteePageController::class, 'journey'])->name('mentee.journey');
    Route::get('messages', [MenteePageController::class, 'messages'])->name('mentee.messages');
    Route::get('resources', [MenteePageController::class, 'resources'])->name('mentee.resources');
    Route::get('cohort', [MenteePageController::class, 'cohort'])->name('mentee.cohort');
    Route::get('schedule', [MenteePageController::class, 'schedule'])->name('mentee.schedule');
    Route::get('settings', [MenteePageController::class, 'settings'])->name('mentee.settings');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('mentee.logout');
});

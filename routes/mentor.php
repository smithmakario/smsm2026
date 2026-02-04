<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\Mentor\MentorPageController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('mentor.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:mentor'])->group(function () {
    Route::get('', MentorDashboardController::class)->name('mentor.index');
    Route::get('cohorts', [MentorPageController::class, 'cohorts'])->name('mentor.cohorts');
    Route::get('cohorts/{cohort}', [MentorPageController::class, 'showCohort'])->name('mentor.cohorts.show');
    Route::put('cohorts/{cohort}', [MentorPageController::class, 'updateCohort'])->name('mentor.cohorts.update');
    Route::get('assignments', [MentorPageController::class, 'assignments'])->name('mentor.assignments');
    Route::get('resources', [MentorPageController::class, 'resources'])->name('mentor.resources');
    Route::get('analytics', [MentorPageController::class, 'analytics'])->name('mentor.analytics');
    Route::get('settings', [MentorPageController::class, 'settings'])->name('mentor.settings');
    Route::get('messages', [MentorPageController::class, 'messages'])->name('mentor.messages');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('mentor.logout');
});

<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Coordinator\CoordinatorDashboardController;
use App\Http\Controllers\Coordinator\CoordinatorPageController;
use App\Http\Controllers\ParticipantEventController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('coordinator.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:coordinator'])->group(function () {
    Route::get('', CoordinatorDashboardController::class)->name('coordinator.index');
    Route::get('cohorts', [CoordinatorPageController::class, 'cohorts'])->name('coordinator.cohorts');
    Route::get('cohorts/{cohort}', [CoordinatorPageController::class, 'showCohort'])->name('coordinator.cohorts.show');
    Route::put('cohorts/{cohort}', [CoordinatorPageController::class, 'updateCohort'])->name('coordinator.cohorts.update');
    Route::post('cohorts/{cohort}/attendance', [CoordinatorPageController::class, 'storeAttendance'])->name('coordinator.cohorts.attendance.store');
    Route::post('cohorts/{cohort}/life-application-questions/{question}/show', [CoordinatorPageController::class, 'showLifeApplicationQuestionToMentee'])->name('coordinator.cohorts.life-application-questions.show');
    Route::post('cohorts/{cohort}/life-application-questions/{question}/hide', [CoordinatorPageController::class, 'hideLifeApplicationQuestionFromMentee'])->name('coordinator.cohorts.life-application-questions.hide');
    Route::get('assignments', [CoordinatorPageController::class, 'assignments'])->name('coordinator.assignments');
    Route::get('resources', [CoordinatorPageController::class, 'resources'])->name('coordinator.resources');
    Route::get('analytics', [CoordinatorPageController::class, 'analytics'])->name('coordinator.analytics');
    Route::get('settings', [CoordinatorPageController::class, 'settings'])->name('coordinator.settings');
    Route::get('messages', [CoordinatorPageController::class, 'messages'])->name('coordinator.messages');
    Route::get('events', [ParticipantEventController::class, 'index'])->name('coordinator.events.index');
    Route::get('events/{event}', [ParticipantEventController::class, 'show'])->name('coordinator.events.show');
    Route::post('events/{event}/register', [ParticipantEventController::class, 'register'])->name('coordinator.events.register');
    Route::post('events/{event}/unregister', [ParticipantEventController::class, 'unregister'])->name('coordinator.events.unregister');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('coordinator.logout');
});

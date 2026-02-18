<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Mentee\MenteeDashboardController;
use App\Http\Controllers\Mentee\MenteePageController;
use App\Http\Controllers\ParticipantEventController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('mentee.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:mentee'])->group(function () {
    Route::get('', MenteeDashboardController::class)->name('mentee.index');
    Route::get('modules/{module}/review', [\App\Http\Controllers\Mentee\ModuleReviewController::class, 'create'])->name('mentee.modules.review.create');
    Route::post('modules/{module}/review', [\App\Http\Controllers\Mentee\ModuleReviewController::class, 'store'])->name('mentee.modules.review.store');
    Route::get('project', [\App\Http\Controllers\Mentee\SemesterProjectController::class, 'index'])->name('mentee.project.index');
    Route::post('project', [\App\Http\Controllers\Mentee\SemesterProjectController::class, 'store'])->name('mentee.project.store');
    Route::get('journey', [MenteePageController::class, 'journey'])->name('mentee.journey');
    Route::get('messages', [MenteePageController::class, 'messages'])->name('mentee.messages');
    Route::get('resources', [MenteePageController::class, 'resources'])->name('mentee.resources');
    Route::get('cohort', [MenteePageController::class, 'cohort'])->name('mentee.cohort');
    Route::get('schedule', [MenteePageController::class, 'schedule'])->name('mentee.schedule');
    Route::get('settings', [MenteePageController::class, 'settings'])->name('mentee.settings');
    Route::get('events', [ParticipantEventController::class, 'index'])->name('mentee.events.index');
    Route::get('events/{event}', [ParticipantEventController::class, 'show'])->name('mentee.events.show');
    Route::post('events/{event}/register', [ParticipantEventController::class, 'register'])->name('mentee.events.register');
    Route::post('events/{event}/unregister', [ParticipantEventController::class, 'unregister'])->name('mentee.events.unregister');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('mentee.logout');
});

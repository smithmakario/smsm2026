<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CohortsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ModuleReviewsController;
use App\Http\Controllers\Admin\ReviewMeetingsController;
use App\Http\Controllers\Admin\SemesterProjectsController;
use App\Http\Controllers\Admin\SemesterReportController;
use App\Http\Controllers\Admin\SemestersController;
use App\Http\Controllers\Admin\SemesterModulesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth', 'user.type:admin'])->group(function () {
    Route::get('', AdminDashboardController::class)->name('admin.index');
    Route::get('cohorts', [CohortsController::class, 'index'])->name('admin.cohorts.index');
    Route::get('cohorts/create', [CohortsController::class, 'create'])->name('admin.cohorts.create');
    Route::post('cohorts', [CohortsController::class, 'store'])->name('admin.cohorts.store');
    Route::get('cohorts/{cohort}', [CohortsController::class, 'show'])->name('admin.cohorts.show');
    Route::get('cohorts/{cohort}/edit', [CohortsController::class, 'edit'])->name('admin.cohorts.edit');
    Route::put('cohorts/{cohort}', [CohortsController::class, 'update'])->name('admin.cohorts.update');
    Route::delete('cohorts/{cohort}', [CohortsController::class, 'destroy'])->name('admin.cohorts.destroy');
    Route::post('cohorts/{cohort}/members', [CohortsController::class, 'addMember'])->name('admin.cohorts.members.add');
    Route::delete('cohorts/{cohort}/members/{user}', [CohortsController::class, 'removeMember'])->name('admin.cohorts.members.remove');
    Route::post('cohorts/{cohort}/at-risk-email/{user}', [CohortsController::class, 'sendAtRiskEmail'])->name('admin.cohorts.at-risk.send-email');
    Route::get('cohorts/{cohort}/review-meetings', [ReviewMeetingsController::class, 'index'])->name('admin.cohorts.review-meetings.index');
    Route::get('cohorts/{cohort}/review-meetings/create', [ReviewMeetingsController::class, 'create'])->name('admin.cohorts.review-meetings.create');
    Route::post('cohorts/{cohort}/review-meetings', [ReviewMeetingsController::class, 'store'])->name('admin.cohorts.review-meetings.store');
    Route::resource('events', EventController::class)->names('admin.events');
    Route::post('events/registrations/{registration}/check-in', [EventController::class, 'checkIn'])->name('admin.events.registrations.check-in');
    Route::post('events/registrations/{registration}/mark-paid', [EventController::class, 'markPaid'])->name('admin.events.registrations.mark-paid');
    Route::post('events/registrations/{registration}/mark-waived', [EventController::class, 'markWaived'])->name('admin.events.registrations.mark-waived');
    Route::post('events/{event}/notifications/reminder', [EventController::class, 'sendReminder'])->name('admin.events.notifications.reminder');
    Route::post('events/{event}/notifications/post-event', [EventController::class, 'sendPostEvent'])->name('admin.events.notifications.post-event');
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('users/upload', [UserController::class, 'upload'])->name('admin.users.upload');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::post('users/upload', [UserController::class, 'storeUpload'])->name('admin.users.storeUpload');
    Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('semesters', [SemestersController::class, 'index'])->name('admin.semesters.index');
    Route::get('semesters/create', [SemestersController::class, 'create'])->name('admin.semesters.create');
    Route::post('semesters', [SemestersController::class, 'store'])->name('admin.semesters.store');
    Route::get('semesters/{semester}', [SemestersController::class, 'show'])->name('admin.semesters.show');
    Route::get('semesters/{semester}/edit', [SemestersController::class, 'edit'])->name('admin.semesters.edit');
    Route::put('semesters/{semester}', [SemestersController::class, 'update'])->name('admin.semesters.update');
    Route::delete('semesters/{semester}', [SemestersController::class, 'destroy'])->name('admin.semesters.destroy');
    Route::post('semesters/{semester}/set-active', [SemestersController::class, 'setActive'])->name('admin.semesters.set-active');
    Route::post('semesters/{semester}/archive', [SemestersController::class, 'archive'])->name('admin.semesters.archive');
    Route::get('semesters/{semester}/modules', [SemesterModulesController::class, 'index'])->name('admin.semesters.modules.index');
    Route::get('semesters/{semester}/modules/create', [SemesterModulesController::class, 'create'])->name('admin.semesters.modules.create');
    Route::post('semesters/{semester}/modules', [SemesterModulesController::class, 'store'])->name('admin.semesters.modules.store');
    Route::get('semesters/{semester}/modules/{module}/edit', [SemesterModulesController::class, 'edit'])->name('admin.semesters.modules.edit');
    Route::put('semesters/{semester}/modules/{module}', [SemesterModulesController::class, 'update'])->name('admin.semesters.modules.update');
    Route::delete('semesters/{semester}/modules/{module}', [SemesterModulesController::class, 'destroy'])->name('admin.semesters.modules.destroy');
    Route::get('semesters/{semester}/module-reviews', [ModuleReviewsController::class, 'index'])->name('admin.semesters.module-reviews.index');
    Route::get('semesters/{semester}/projects', [SemesterProjectsController::class, 'index'])->name('admin.semesters.projects.index');
    Route::get('semesters/{semester}/projects/create', [SemesterProjectsController::class, 'create'])->name('admin.semesters.projects.create');
    Route::post('semesters/{semester}/projects', [SemesterProjectsController::class, 'store'])->name('admin.semesters.projects.store');
    Route::get('semesters/{semester}/projects/{semester_project}/edit', [SemesterProjectsController::class, 'edit'])->name('admin.semesters.projects.edit');
    Route::put('semesters/{semester}/projects/{semester_project}', [SemesterProjectsController::class, 'update'])->name('admin.semesters.projects.update');
    Route::delete('semesters/{semester}/projects/{semester_project}', [SemesterProjectsController::class, 'destroy'])->name('admin.semesters.projects.destroy');
    Route::get('semesters/{semester}/mentee-projects', [SemesterProjectsController::class, 'menteeProjects'])->name('admin.semesters.mentee-projects');
    Route::put('semesters/{semester}/mentee-projects/{mentee_semester_project}', [SemesterProjectsController::class, 'updateMenteeProject'])->name('admin.semesters.mentee-projects.update');
    Route::get('semesters/{semester}/report', [SemesterReportController::class, 'show'])->name('admin.semesters.report');
    Route::get('audit-logs', AuditLogsController::class)->name('admin.logs');
    Route::get('settings', SettingsController::class)->name('admin.settings');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});

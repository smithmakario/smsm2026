<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CohortsController;
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
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::get('audit-logs', AuditLogsController::class)->name('admin.logs');
    Route::get('settings', SettingsController::class)->name('admin.settings');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});

<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CohortsController;
use App\Http\Controllers\Admin\RBACController;
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
    Route::get('cohorts', CohortsController::class)->name('admin.cohorts');
    Route::get('rbac', RBACController::class)->name('admin.rbac');
    Route::get('audit-logs', AuditLogsController::class)->name('admin.logs');
    Route::get('settings', SettingsController::class)->name('admin.settings');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});

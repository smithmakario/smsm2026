<?php
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\CohortsController;
use App\Http\Controllers\Admin\RBACController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('', AdminDashboardController::class)->middleware('auth:admin')->name('admin.index');
Route::get('cohorts', CohortsController::class)->middleware('auth:admin')->name('admin.cohorts');
Route::get('rbac', RBACController::class)->middleware('auth:admin')->name('admin.rbac');
Route::get('audit-logs', AuditLogsController::class)->middleware('auth:admin')->name('admin.logs');
Route::get('settings', SettingsController::class)->middleware('auth:admin')->name('admin.settings');

require __DIR__ . '/admin_auth.php';

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $adminCount = User::where('user_type', User::TYPE_ADMIN)->count();
        $coordinatorCount = User::where('user_type', User::TYPE_COORDINATOR)->count();
        $menteeCount = User::where('user_type', User::TYPE_MENTEE)->count();
        $cohorts = Cohort::with('coordinator')->withCount('members')->orderBy('name')->take(5)->get();

        return view('admin.admin-dashboard', compact('adminCount', 'coordinatorCount', 'menteeCount', 'cohorts'));
    }
}

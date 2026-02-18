<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoordinatorDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $cohorts = auth()->user()->coordinatedCohorts()->with('members')->orderBy('name')->take(3)->get();

        return view('coordinator.dashboard', ['activeSidebar' => 'dashboard', 'cohorts' => $cohorts]);
    }
}

<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MentorDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $cohorts = auth()->user()->mentoredCohorts()->with('members')->orderBy('name')->take(3)->get();

        return view('mentor.dashboard', ['activeSidebar' => 'dashboard', 'cohorts' => $cohorts]);
    }
}

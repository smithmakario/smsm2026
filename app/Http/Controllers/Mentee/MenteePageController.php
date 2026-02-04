<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class MenteePageController extends Controller
{
    public function journey(): View
    {
        return view('mentee.journey', ['activeNav' => 'journey', 'activeSidebar' => 'journey']);
    }

    public function messages(): View
    {
        return view('mentee.messages', ['activeNav' => 'messages', 'activeSidebar' => null]);
    }

    public function resources(): View
    {
        return view('mentee.resources', ['activeNav' => 'resources', 'activeSidebar' => null]);
    }

    public function cohort(): View
    {
        $cohort = auth()->user()?->cohort();
        if ($cohort) {
            $cohort->load(['mentor', 'members']);
        }

        return view('mentee.cohort', ['activeNav' => null, 'activeSidebar' => 'cohort', 'cohort' => $cohort]);
    }

    public function schedule(): View
    {
        return view('mentee.schedule', ['activeNav' => null, 'activeSidebar' => 'schedule']);
    }

    public function settings(): View
    {
        return view('mentee.settings', ['activeNav' => null, 'activeSidebar' => 'settings']);
    }
}

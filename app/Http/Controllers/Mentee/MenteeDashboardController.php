<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenteeDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $activeSemester = Semester::active()->first();
        $currentModule = null;
        $myReview = null;

        if ($activeSemester) {
            $week = $activeSemester->currentWeekNumber();
            if ($week !== null) {
                $currentModule = $activeSemester->modules()
                    ->where('week_number', $week)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->first();
                if ($currentModule) {
                    $myReview = $currentModule->reviews()->where('user_id', $request->user()->id)->first();
                }
            }
        }

        return view('mentee.dashboard', [
            'activeNav' => 'dashboard',
            'activeSidebar' => 'home',
            'activeSemester' => $activeSemester,
            'currentModule' => $currentModule,
            'myReview' => $myReview,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use App\Models\Module;
use App\Models\ModuleReview;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleReviewsController extends Controller
{
    public function index(Request $request, Semester $semester): View
    {
        $week = $request->integer('week', $semester->currentWeekNumber() ?? 1);
        $week = min(max(1, $week), 12);

        $module = $semester->modules()->where('week_number', $week)->first();
        $submittedUserIds = $module
            ? $module->reviews()->pluck('user_id')->toArray()
            : [];

        $cohorts = Cohort::with('mentees')->orderBy('name')->get();

        $byCohort = [];
        foreach ($cohorts as $cohort) {
            $mentees = $cohort->mentees;
            $submitted = $mentees->filter(fn ($m) => in_array($m->id, $submittedUserIds));
            $pending = $mentees->diff($submitted);
            $total = $mentees->count();
            $rate = $total > 0 ? (int) round(($submitted->count() / $total) * 100) : 0;

            $reviews = $module
                ? ModuleReview::where('module_id', $module->id)->whereIn('user_id', $mentees->pluck('id'))->with('user')->get()->keyBy('user_id')
                : collect();

            $byCohort[] = [
                'cohort' => $cohort,
                'mentees' => $mentees,
                'submitted' => $submitted,
                'pending' => $pending,
                'total' => $total,
                'rate' => $rate,
                'reviews' => $reviews,
            ];
        }

        return view('admin.semesters.module-reviews.index', [
            'semester' => $semester,
            'week' => $week,
            'module' => $module,
            'byCohort' => $byCohort,
            'weeks' => range(1, 12),
        ]);
    }
}

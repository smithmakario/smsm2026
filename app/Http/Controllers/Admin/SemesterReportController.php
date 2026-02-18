<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleReview;
use App\Models\Semester;
use App\Models\User;
use App\Models\UserSemesterPoints;
use Illuminate\View\View;

class SemesterReportController extends Controller
{
    public function show(Semester $semester): View
    {
        $totalMentees = User::where('user_type', User::TYPE_MENTEE)->count();
        $totalMenteesForRate = $totalMentees ?: 1;

        $participationByWeek = [];
        for ($week = 1; $week <= 12; $week++) {
            $module = $semester->modules()->where('week_number', $week)->first();
            if (! $module) {
                $participationByWeek[$week] = ['submitted' => 0, 'total' => $totalMentees, 'rate' => 0];
                continue;
            }
            $submitted = $module->reviews()->pluck('user_id')->unique()->count();
            $rate = (int) round(($submitted / $totalMenteesForRate) * 100);
            $participationByWeek[$week] = ['submitted' => $submitted, 'total' => $totalMentees, 'rate' => $rate];
        }

        $completedOrVerified = \App\Models\MenteeSemesterProject::whereHas('semesterProject', fn ($q) => $q->where('semester_id', $semester->id))
            ->whereIn('status', [\App\Models\MenteeSemesterProject::STATUS_COMPLETED, \App\Models\MenteeSemesterProject::STATUS_VERIFIED])
            ->pluck('user_id')->unique()->count();
        $projectCompletionRate = (int) round(($completedOrVerified / $totalMenteesForRate) * 100);

        $topContributors = UserSemesterPoints::where('semester_id', $semester->id)
            ->with('user')
            ->orderByDesc('points')
            ->take(20)
            ->get();

        $reviewThemes = [];
        $reviews = ModuleReview::whereHas('module', fn ($q) => $q->where('semester_id', $semester->id))
            ->pluck('content');
        if ($reviews->isNotEmpty()) {
            $allText = $reviews->implode(' ');
            $words = str_word_count(mb_strtolower($allText), 1);
            $stop = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'is', 'was', 'are', 'were', 'been', 'be', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'must', 'can', 'this', 'that', 'these', 'those', 'i', 'my', 'me', 'we', 'our', 'you', 'your', 'he', 'she', 'it', 'they', 'them'];
            $filtered = array_diff($words, $stop);
            $counts = array_count_values($filtered);
            arsort($counts);
            $reviewThemes = array_slice(array_keys($counts), 0, 15);
        }

        return view('admin.semesters.report', [
            'semester' => $semester,
            'participationByWeek' => $participationByWeek,
            'totalMentees' => $totalMentees,
            'projectCompletionRate' => $projectCompletionRate,
            'completedOrVerified' => $completedOrVerified,
            'topContributors' => $topContributors,
            'reviewThemes' => $reviewThemes,
        ]);
    }
}

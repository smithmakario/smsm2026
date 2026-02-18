<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleReviewController extends Controller
{
    public function create(Module $module): View|RedirectResponse
    {
        $user = request()->user();
        if (! $module->semester->is_active || ! $module->isPublished()) {
            return redirect()->route('mentee.index')->with('error', 'This module is not available.');
        }
        if ($module->semester->currentWeekNumber() !== $module->week_number) {
            return redirect()->route('mentee.index')->with('error', 'This module is not the current week\'s module.');
        }

        $review = ModuleReview::where('user_id', $user->id)->where('module_id', $module->id)->first();
        $module->load([
            'lifeApplicationQuestions' => fn ($query) => $query->where('is_visible_to_mentee', true),
        ]);

        return view('mentee.modules.review', [
            'module' => $module,
            'review' => $review,
            'activeNav' => 'dashboard',
            'activeSidebar' => 'home',
        ]);
    }

    public function store(Request $request, Module $module): RedirectResponse
    {
        $user = $request->user();
        if (! $module->semester->is_active || ! $module->isPublished()) {
            return redirect()->route('mentee.index')->with('error', 'This module is not available.');
        }
        if ($module->semester->currentWeekNumber() !== $module->week_number) {
            return redirect()->route('mentee.index')->with('error', 'This module is not the current week\'s module.');
        }

        $request->validate([
            'content' => ['required', 'string', 'max:10000'],
        ]);

        ModuleReview::updateOrCreate(
            ['user_id' => $user->id, 'module_id' => $module->id],
            ['content' => $request->content],
        );

        return redirect()->route('mentee.index')
            ->with('status', 'Your review has been submitted.');
    }
}

<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MentorDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('mentor.dashboard');
    }
}

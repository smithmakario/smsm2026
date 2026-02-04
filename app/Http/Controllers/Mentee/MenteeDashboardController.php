<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenteeDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('mentee.dashboard');
    }
}

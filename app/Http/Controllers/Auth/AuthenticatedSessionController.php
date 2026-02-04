<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view for the current area (admin, mentor, mentee).
     */
    public function create(Request $request): View
    {
        $area = $this->resolveAreaFromRoute();
        $routeName = $request->route()?->getName() ?? '';
        $loginRoute = $routeName === 'login' ? 'login' : ($area . '.login');
        $title = match ($area) {
            'admin' => 'Admin Login',
            'mentor' => 'Mentor Login',
            'mentee' => 'Mentee Login',
            default => 'Login',
        };

        return view('auth.login', [
            'area' => $area,
            'loginRoute' => $loginRoute,
            'title' => $title,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $expectedType = $this->resolveUserTypeFromRoute();

        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if (!$user instanceof User || $user->user_type !== $expectedType) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => __('You do not have access to this area.'),
            ])->onlyInput('email');
        }

        $dashboardRoute = $expectedType . '.index';
        return redirect()->intended(route($dashboardRoute));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $loginRoute = match ($request->route()?->getName()) {
            'admin.logout' => 'admin.login',
            'mentor.logout' => 'mentor.login',
            'mentee.logout' => 'mentee.login',
            default => 'admin.login',
        };

        return redirect()->route($loginRoute);
    }

    private function resolveAreaFromRoute(): string
    {
        $name = request()->route()?->getName() ?? '';
        if (str_starts_with($name, 'admin.')) {
            return 'admin';
        }
        if (str_starts_with($name, 'mentor.')) {
            return 'mentor';
        }
        if (str_starts_with($name, 'mentee.')) {
            return 'mentee';
        }

        // POST routes may have no name; resolve from URL path
        $firstSegment = request()->segment(1);
        if (in_array($firstSegment, ['admin', 'mentor', 'mentee'], true)) {
            return $firstSegment;
        }

        return 'admin';
    }

    private function resolveUserTypeFromRoute(): string
    {
        $area = $this->resolveAreaFromRoute();
        return $area === 'admin' ? User::TYPE_ADMIN
            : ($area === 'mentor' ? User::TYPE_MENTOR : User::TYPE_MENTEE);
    }
}

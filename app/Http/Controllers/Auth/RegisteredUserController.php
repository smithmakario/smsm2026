<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeRegistered;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration wizard.
     */
    public function create(): View
    {
        return view('auth.register', [
            'maritalStatuses' => config('onboarding.marital_statuses'),
            'occupationCategories' => config('onboarding.occupation_categories'),
            'nigerianStates' => config('onboarding.nigerian_states'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'marital_status' => ['nullable', 'string', 'in:'.implode(',', array_keys(config('onboarding.marital_statuses')))],
            'occupation' => ['nullable', 'string', 'max:255'],
            'occupation_category' => ['nullable', 'string', 'in:'.implode(',', array_keys(config('onboarding.occupation_categories')))],
            'church' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'user_type' => User::TYPE_MENTEE,
            'password' => Hash::make($request->password),
            'marital_status' => $request->marital_status,
            'occupation' => $request->occupation,
            'occupation_category' => $request->occupation_category,
            'church' => $request->church,
            'country' => $request->country ?: 'Nigeria',
            'state' => $request->state,
            'city' => $request->city,
        ]);

        event(new Registered($user));
        Mail::to($user->email)->send(new WelcomeRegistered($user));

        Auth::login($user);

        return redirect()->route('mentee.index');
    }
}

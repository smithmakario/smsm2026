<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeRegistered;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the users table.
     */
    public function index(Request $request): View
    {
        $query = User::query()->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user (admin-only registration).
     */
    public function create(): View
    {
        return view('admin.users.create', [
            'userTypes' => [
                User::TYPE_ADMIN => 'Admin',
                User::TYPE_MENTOR => 'Mentor',
                User::TYPE_MENTEE => 'Mentee',
            ],
            'maritalStatuses' => config('onboarding.marital_statuses', []),
            'occupationCategories' => config('onboarding.occupation_categories', []),
            'nigerianStates' => config('onboarding.nigerian_states', []),
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['nullable', 'string', 'max:50'],
            'user_type' => ['required', 'string', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_MENTOR . ',' . User::TYPE_MENTEE],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'marital_status' => ['nullable', 'string', 'in:' . implode(',', array_keys(config('onboarding.marital_statuses', [])))],
            'occupation' => ['nullable', 'string', 'max:255'],
            'occupation_category' => ['nullable', 'string', 'in:' . implode(',', array_keys(config('onboarding.occupation_categories', [])))],
            'church' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
            'marital_status' => $request->marital_status,
            'occupation' => $request->occupation,
            'occupation_category' => $request->occupation_category,
            'church' => $request->church,
            'country' => $request->country ?: 'Nigeria',
            'state' => $request->state,
            'city' => $request->city,
        ]);

        Mail::to($user->email)->send(new WelcomeRegistered($user));

        return redirect()->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'userTypes' => [
                User::TYPE_ADMIN => 'Admin',
                User::TYPE_MENTOR => 'Mentor',
                User::TYPE_MENTEE => 'Mentee',
            ],
            'maritalStatuses' => config('onboarding.marital_statuses', []),
            'occupationCategories' => config('onboarding.occupation_categories', []),
            'nigerianStates' => config('onboarding.nigerian_states', []),
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'user_type' => ['required', 'string', 'in:' . User::TYPE_ADMIN . ',' . User::TYPE_MENTOR . ',' . User::TYPE_MENTEE],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'marital_status' => ['nullable', 'string', 'in:' . implode(',', array_keys(config('onboarding.marital_statuses', [])))],
            'occupation' => ['nullable', 'string', 'max:255'],
            'occupation_category' => ['nullable', 'string', 'in:' . implode(',', array_keys(config('onboarding.occupation_categories', [])))],
            'church' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'marital_status' => $request->marital_status,
            'occupation' => $request->occupation,
            'occupation_category' => $request->occupation_category,
            'church' => $request->church,
            'country' => $request->country ?: 'Nigeria',
            'state' => $request->state,
            'city' => $request->city,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }
}

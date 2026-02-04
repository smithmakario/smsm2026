<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UserController extends Controller
{
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
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.create')
            ->with('status', 'User created successfully.');
    }
}

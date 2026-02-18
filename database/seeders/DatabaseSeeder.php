<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@example.com',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => null,
                'user_type' => User::TYPE_ADMIN,
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'coordinator@example.com',
                'first_name' => 'Coordinator',
                'last_name' => 'User',
                'phone' => null,
                'user_type' => User::TYPE_COORDINATOR,
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'mentee@example.com',
                'first_name' => 'Mentee',
                'last_name' => 'User',
                'phone' => null,
                'user_type' => User::TYPE_MENTEE,
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}

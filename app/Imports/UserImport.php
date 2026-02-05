<?php

namespace App\Imports;

use App\Mail\WelcomeRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'first_name' => $row[0],
            'last_name' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'user_type' => $row[4],
            'password' => Hash::make($row[5]),
            'marital_status' => $row[6],
            'occupation' => $row[7],
            'occupation_category' => $row[8],
            'church' => $row[9],
            'country' => $row[10] ?: 'Nigeria',
            'state' => $row[11],
            'city' => $row[12],
        ]);

        Mail::to($user->email)->send(new WelcomeRegistered($user));

        return $user;
    }

    public function startRow(): int
    {
        return 2;
    }
}

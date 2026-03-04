<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Demo Employee',
            'email' => 'employee@mail.com',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'shift_id' => 1,
            'position' => 'Developer',
        ]);
    }
}

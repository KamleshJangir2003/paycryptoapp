<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['mobile' => '9999999999'], [
            'name'        => 'Admin',
            'password'    => Hash::make('admin123'),
            'role'        => 'admin',
            'is_verified' => true,
            'is_active'   => true,
        ]);

        User::firstOrCreate(['mobile' => '8888888888'], [
            'name'        => 'Test User',
            'password'    => Hash::make('user123'),
            'role'        => 'user',
            'is_verified' => true,
            'is_active'   => true,
        ]);
    }
}

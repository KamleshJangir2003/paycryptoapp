<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'        => 'Admin',
            'mobile'      => '9999999999',
            'password'    => Hash::make('admin123'),
            'role'        => 'admin',
            'is_verified' => true,
            'is_active'   => true,
        ]);
    }
}

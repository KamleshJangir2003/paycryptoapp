<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@fastpayz.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('admin@123'), 'is_active' => true]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@arisanbarokah.com',
            'password' => Hash::make('password123'),
            'role_id' => 1, // admin
        ]);
    }
}
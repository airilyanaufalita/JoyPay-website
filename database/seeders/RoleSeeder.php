<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // contoh seeding role
        $roles = ['admin','user','guest'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}

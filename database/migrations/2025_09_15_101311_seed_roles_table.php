<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedRolesTable extends Migration
{
    public function up()
    {
        // Insert default roles
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'merchant', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        DB::table('roles')->whereIn('id', [1, 2, 3])->delete();
    }
}
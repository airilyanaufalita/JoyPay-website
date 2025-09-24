<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('roles', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // contoh: admin, user, client, freelancer
        $table->timestamps();
    });

    // tambah kolom role_id ke tabel users
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('role_id')->default(2)->constrained('roles'); // default ke user
});
}

};
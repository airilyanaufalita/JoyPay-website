<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'username')) {
            $table->string('username')->unique()->after('id');
        }
        $table->string('address')->nullable();
        $table->string('phone')->nullable();
        $table->string('emergency_phone')->nullable();
        $table->string('social_media')->nullable();
        $table->string('account_number')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'username',
            'address',
            'phone',
            'emergency_phone',
            'social_media',
            'account_number',
        ]);
    });
}

};

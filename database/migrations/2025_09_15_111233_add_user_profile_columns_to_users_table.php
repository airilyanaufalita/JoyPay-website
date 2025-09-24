<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan semua kolom yang disebutkan dalam error
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 15)->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('users', 'emergency_phone')) {
                $table->string('emergency_phone', 15)->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'social_media')) {
                $table->string('social_media')->nullable()->after('emergency_phone');
            }
            
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number', 50)->nullable()->after('social_media');
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('account_number');
            }
            
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type', 20)->default('regular')->after('status');
            }
            
            // Juga tambahkan kolom role_id jika belum ada
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->default(2)->after('password');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [
                'address', 'phone', 'emergency_phone', 'social_media',
                'account_number', 'status', 'type', 'role_id'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
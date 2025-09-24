<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kloter_members', function (Blueprint $table) {
            // Cek apakah kolom monthly_payment sudah ada
            if (!Schema::hasColumn('kloter_members', 'monthly_payment')) {
                $table->decimal('monthly_payment', 15, 2)->default(0)->after('slot_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kloter_members', function (Blueprint $table) {
            // Drop kolom monthly_payment jika ada
            if (Schema::hasColumn('kloter_members', 'monthly_payment')) {
                $table->dropColumn('monthly_payment');
            }
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kloters', function (Blueprint $table) {
            $table->json('payment')->nullable()->change();
            $table->json('draw')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kloters', function (Blueprint $table) {
            $table->json('payment')->change();
            $table->json('draw')->change();
        });
    }
};
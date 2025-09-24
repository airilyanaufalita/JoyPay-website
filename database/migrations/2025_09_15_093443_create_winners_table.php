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
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemenang');
            $table->string('email_pemenang');
            $table->string('no_telepon');
            $table->string('kloter_name');
            $table->integer('periode');
            $table->decimal('jumlah_hadiah', 15, 2);
            $table->date('tanggal_undian');
            $table->enum('status', ['pending', 'confirmed', 'paid'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
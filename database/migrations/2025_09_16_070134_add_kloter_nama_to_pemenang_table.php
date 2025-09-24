<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemenang', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('pemenang', 'kloter_nama')) {
                $table->string('kloter_nama')->after('id')->nullable();
            }
            
            // Jika perlu menambahkan kolom lain yang disebut dalam error
            if (!Schema::hasColumn('pemenang', 'kloter_id')) {
                $table->unsignedBigInteger('kloter_id')->after('kloter_nama')->nullable();
            }
            
            if (!Schema::hasColumn('pemenang', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('kloter_id')->nullable();
            }
            
            if (!Schema::hasColumn('pemenang', 'user_nama')) {
                $table->string('user_nama')->after('user_id')->nullable();
            }
            
            if (!Schema::hasColumn('pemenang', 'periode_ke')) {
                $table->integer('periode_ke')->after('user_nama')->default(1);
            }
            
            if (!Schema::hasColumn('pemenang', 'hadiah')) {
                $table->decimal('hadiah', 15, 2)->after('periode_ke')->default(0);
            }
            
            if (!Schema::hasColumn('pemenang', 'tanggal_menang')) {
                $table->date('tanggal_menang')->after('hadiah')->nullable();
            }
            
            if (!Schema::hasColumn('pemenang', 'status_pencairan')) {
                $table->enum('status_pencairan', ['belum', 'proses', 'selesai'])->after('tanggal_menang')->default('belum');
            }
            
            if (!Schema::hasColumn('pemenang', 'catatan')) {
                $table->text('catatan')->after('status_pencairan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pemenang', function (Blueprint $table) {
            // Hapus kolom jika ada (untuk rollback)
            $columnsToDrop = [
                'kloter_nama', 'kloter_id', 'user_id', 'user_nama',
                'periode_ke', 'hadiah', 'tanggal_menang', 'status_pencairan', 'catatan'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('pemenang', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
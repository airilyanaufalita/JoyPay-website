<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemporaryFixKloterMembersConstraints extends Migration
{
    public function up()
    {
        Schema::table('kloter_members', function (Blueprint $table) {
            // Drop foreign key constraint pada verified_by
            $table->dropForeign(['verified_by']);
            
            // Ubah jadi nullable integer biasa tanpa constraint
            $table->unsignedBigInteger('verified_by')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('kloter_members', function (Blueprint $table) {
            // Kembalikan constraint jika rollback
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }
}
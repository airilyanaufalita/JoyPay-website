<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('kloters', function (Blueprint $table) {  // Ganti 'kloter' ke 'kloters'
        $table->id();
        $table->string('name', 100);
        $table->text('description')->nullable();
        $table->timestamp('created_at')->nullable();
        $table->timestamp('updated_at')->nullable();
        $table->enum('category', ['harian', 'mingguan', 'bulanan']);
        $table->decimal('nominal', 15, 2)->unsigned();
        $table->integer('duration_value');
        $table->enum('duration_unit', ['hari', 'minggu', 'bulan']);
        $table->integer('total_slots');
        $table->integer('filled_slots')->default(0);
        $table->decimal('admin_fee_percentage', 5, 2);
        $table->decimal('admin_fee_amount', 15, 2);
        $table->enum('status', ['open', 'full', 'running', 'completed'])->default('open');
        $table->string('payment_schedule', 100)->nullable();
        $table->string('draw_schedule', 100)->nullable();
        $table->date('start_date')->nullable();
        $table->integer('current_period')->default(0);
        $table->string('manager_name', 255)->nullable();
        $table->string('payment_method', 100)->default('Transfer Bank');

    });
    Schema::table('kloter_members', function (Blueprint $table) {
    $table->text('rejection_note')->nullable()->after('payment_status');
});
}

public function down()
{
    Schema::dropIfExists('kloters');  // Ganti ke 'kloters'
}
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKloterPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('kloter_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kloter_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained('kloter_members')->onDelete('cascade');
            $table->integer('period');
            $table->decimal('amount', 15, 2);
            $table->decimal('admin_fee', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->date('payment_date')->nullable();
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'late', 'failed'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamps();
            
            $table->index(['kloter_id', 'period']);
            $table->index(['member_id', 'status']);
            $table->index(['due_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kloter_payments');
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKloterDrawsTable extends Migration
{
    public function up()
    {
        Schema::create('kloter_draws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kloter_id')->constrained()->onDelete('cascade');
            $table->foreignId('winner_member_id')->constrained('kloter_members')->onDelete('cascade');
            $table->integer('period');
            $table->date('draw_date');
            $table->decimal('total_collected', 15, 2);
            $table->decimal('admin_fee_deducted', 15, 2);
            $table->decimal('winner_payout', 15, 2);
            $table->string('draw_method')->default('Digital Random');
            $table->boolean('is_paid_out')->default(false);
            $table->date('payout_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['kloter_id', 'period']);
            $table->index(['draw_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kloter_draws');
    }
}
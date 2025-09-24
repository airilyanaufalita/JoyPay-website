<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('kloter_member_requests', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kloter_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('slot_number');
    $table->decimal('monthly_payment', 15, 2);
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->text('rejection_note')->nullable();
    $table->timestamp('joined_at')->useCurrent();
    $table->timestamp('verified_at')->nullable();
    $table->foreignId('verified_by')->nullable()->constrained('users');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('kloter_member_requests');
    }
};
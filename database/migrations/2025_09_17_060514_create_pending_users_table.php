<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('social_media')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('password');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('type')->default('regular'); // regular, premium, vip
            $table->text('rejection_reason')->nullable();
            $table->text('improvement_suggestion')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_users');
    }
};
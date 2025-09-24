<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKloterRulesTable extends Migration
{
    public function up()
    {
Schema::create('kloter_rules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kloter_id')->constrained('kloters')->onDelete('cascade');
    $table->text('rule_text');
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('kloter_rules');
    }
}

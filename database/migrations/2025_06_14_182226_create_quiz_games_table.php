<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('room_code', 6)->unique();
            $table->enum('status', ['waiting', 'active', 'finished'])->default('waiting');
            $table->enum('mode', ['realtime', 'free'])->default('realtime');
            $table->integer('current_stage')->default(1); // 1, 2, 3
            $table->integer('current_question')->default(1);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_games');
    }
};
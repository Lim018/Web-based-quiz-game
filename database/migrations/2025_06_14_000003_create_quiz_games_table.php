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
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('room_code', 6)->unique();
            $table->enum('mode', ['realtime', 'free']);
            $table->enum('status', ['waiting', 'active', 'finished'])->default('waiting');
            $table->tinyInteger('current_stage')->default(1);
            $table->tinyInteger('current_question')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['room_code', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_games');
    }
};
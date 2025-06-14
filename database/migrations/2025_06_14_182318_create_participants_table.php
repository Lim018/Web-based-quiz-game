<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_game_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('session_id');
            $table->integer('total_score')->default(0);
            $table->integer('stage_1_score')->default(0);
            $table->integer('stage_2_score')->default(0);
            $table->integer('stage_3_score')->default(0);
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

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
       Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('stage'); // 1=MCQ, 2=Fill, 3=True/False
            $table->integer('question_number'); // 1-20 for each stage
            $table->text('question');
            $table->json('options')->nullable(); // For MCQ and True/False
            $table->string('correct_answer');
            $table->integer('points')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};

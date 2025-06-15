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
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('stage'); // 1=MCQ, 2=Short Answer, 3=True/False
            $table->tinyInteger('question_number');
            $table->text('question');
            $table->enum('type', ['mcq', 'short_answer', 'true_false']);
            $table->json('options')->nullable(); // For MCQ options
            $table->string('correct_answer');
            $table->text('explanation')->nullable();
            $table->integer('points')->default(10);
            $table->integer('time_limit')->nullable(); // Override quiz default if needed
            $table->timestamps();

            $table->index(['quiz_id', 'stage', 'question_number']);
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

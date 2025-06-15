<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'stage',
        'question_number',
        'question',
        'type',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'time_limit'
    ];

    protected $casts = [
        'options' => 'array',
        'stage' => 'integer',
        'question_number' => 'integer',
        'points' => 'integer',
        'time_limit' => 'integer'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function participantAnswers(): HasMany
    {
        return $this->hasMany(ParticipantAnswer::class);
    }

    public function checkAnswer(string $answer): bool
    {
        $answer = trim($answer);
        $correctAnswer = trim($this->correct_answer);

        switch ($this->type) {
            case 'mcq':
                return strtolower($answer) === strtolower($correctAnswer);
            
            case 'true_false':
                return strtolower($answer) === strtolower($correctAnswer);
            
            case 'short_answer':
                // For short answer, we can be more flexible
                return strtolower($answer) === strtolower($correctAnswer) ||
                       str_contains(strtolower($correctAnswer), strtolower($answer));
            
            default:
                return false;
        }
    }

    public function getTypeDisplayName(): string
    {
        return match($this->type) {
            'mcq' => 'Pilihan Ganda',
            'short_answer' => 'Isian Singkat',
            'true_false' => 'Benar/Salah',
            default => 'Unknown'
        };
    }
}
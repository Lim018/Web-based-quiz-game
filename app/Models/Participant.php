<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_game_id',
        'name',
        'session_id',
        'total_score',
        'stage_1_score',
        'stage_2_score',
        'stage_3_score',
        'is_finished'
    ];

    protected $casts = [
        'total_score' => 'integer',
        'stage_1_score' => 'integer',
        'stage_2_score' => 'integer',
        'stage_3_score' => 'integer',
        'is_finished' => 'boolean'
    ];

    public function quizGame(): BelongsTo
    {
        return $this->belongsTo(QuizGame::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ParticipantAnswer::class);
    }

    public function updateScore(int $stage, int $points): void
    {
        $stageField = "stage_{$stage}_score";
        
        $this->increment($stageField, $points);
        $this->increment('total_score', $points);
    }

    public function getCorrectAnswersCount(): int
    {
        return $this->answers()->where('is_correct', true)->count();
    }

    public function getTotalAnswersCount(): int
    {
        return $this->answers()->count();
    }

    public function getAccuracyPercentage(): float
    {
        $total = $this->getTotalAnswersCount();
        if ($total === 0) return 0;
        
        return round(($this->getCorrectAnswersCount() / $total) * 100, 2);
    }
}
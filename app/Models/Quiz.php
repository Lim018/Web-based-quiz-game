<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'time_per_question',
        'created_by',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_per_question' => 'integer'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(QuizGame::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function getQuestionsByStage($stage): HasMany
    {
        return $this->questions()->where('stage', $stage)->orderBy('question_number');
    }

    public function getTotalQuestions(): int
    {
        return $this->questions()->count();
    }

    public function getStageQuestionCount($stage): int
    {
        return $this->questions()->where('stage', $stage)->count();
    }
}

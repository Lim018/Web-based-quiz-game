<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage',
        'question_number',
        'question',
        'options',
        'correct_answer',
        'points'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function participantAnswers()
    {
        return $this->hasMany(ParticipantAnswer::class);
    }

    public function checkAnswer($answer)
    {
        return strtolower(trim($answer)) === strtolower(trim($this->correct_answer));
    }
}

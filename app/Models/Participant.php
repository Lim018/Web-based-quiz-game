<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function quizGame()
    {
        return $this->belongsTo(QuizGame::class);
    }

    public function answers()
    {
        return $this->hasMany(ParticipantAnswer::class);
    }

    public function updateScore($stage, $points)
    {
        $stageColumn = "stage_{$stage}_score";
        $this->$stageColumn += $points;
        $this->total_score = $this->stage_1_score + $this->stage_2_score + $this->stage_3_score;
        $this->save();
    }
}

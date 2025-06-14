<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'room_code',
        'status',
        'mode',
        'current_stage',
        'current_question',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function generateRoomCode()
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (self::where('room_code', $code)->exists());
        
        return $code;
    }

    public function getCurrentQuestion()
    {
        return Question::where('stage', $this->current_stage)
                      ->where('question_number', $this->current_question)
                      ->first();
    }

    public function getLeaderboard()
    {
        return $this->participants()
                   ->orderBy('total_score', 'desc')
                   ->orderBy('created_at', 'asc')
                   ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantAnswer extends Model
{
   use HasFactory;

    protected $fillable = [
        'participant_id',
        'question_id',
        'answer',
        'is_correct',
        'points_earned',
        'answered_at'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

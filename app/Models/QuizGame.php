<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'title',
        'room_code',
        'mode',
        'status',
        'current_stage',
        'current_question',
        'started_at',
        'finished_at',
        'created_by'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'current_stage' => 'integer',
        'current_question' => 'integer'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function getCurrentQuestion()
    {
        return $this->quiz->questions()
                         ->where('stage', $this->current_stage)
                         ->where('question_number', $this->current_question)
                         ->first();
    }

    public function getLeaderboard()
    {
        return $this->participants()
                   ->orderBy('total_score', 'desc')
                   ->orderBy('updated_at', 'asc')
                   ->get();
    }

    public function generateRoomCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        } while (self::where('room_code', $code)->exists());

        return $code;
    }
}

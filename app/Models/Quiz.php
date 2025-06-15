<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'mode',
        'room_code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function leaderboard()
    {
        return $this->participants()
            ->whereNotNull('finished_at')
            ->orderBy('total_score', 'desc')
            ->orderBy('finished_at', 'asc');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
   use HasFactory;

    protected $fillable = [
        'quiz_id',
        'nickname',
        'total_score',
        'finished_at'
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}

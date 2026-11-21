<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_id', 'participant_name', 'university',
        'score', 'correct_count', 'total_questions', 'readiness_verdict'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

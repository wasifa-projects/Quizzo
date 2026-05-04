<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'user_id', 
        'quiz_id', 
        'score', 
        'total'
    ];

    // Link back to the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link back to the Quiz
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
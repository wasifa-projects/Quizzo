<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
    'quiz_id', 'question_text', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option'
];

    public function options() {
        return $this->hasMany(Option::class);
    }
}
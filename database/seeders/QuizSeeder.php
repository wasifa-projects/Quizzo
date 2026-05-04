<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quiz = Quiz::create([
            'title' => 'Web Development Basics',
            'category' => 'Technology',
            'time_limit' => 15,
        ]);

        $quiz->questions()->create([
            'question_text' => 'What does HTML stand for?',
            'option_a' => 'Hyper Text Markup Language',
            'option_b' => 'High Tech Modern Language',
            'option_c' => 'Hyperlink Text Management',
            'option_d' => 'None of the above',
            'correct_option' => 'a',
        ]);
    }
}
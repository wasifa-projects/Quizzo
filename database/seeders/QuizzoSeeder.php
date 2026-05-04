<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizzoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // 1. Create the Quiz
    $quiz = \App\Models\Quiz::create(['title' => 'Laravel & Herd Basics']);

    // 2. Create a Question
    $q1 = \App\Models\Question::create([
        'quiz_id' => $quiz->id,
        'question_text' => 'Which tool is used to manage PHP versions on Windows?'
    ]);

    // 3. Create Options for Question 1
    \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'XAMPP', 'is_correct' => false]);
    \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'Laravel Herd', 'is_correct' => true]);
    \App\Models\Option::create(['question_id' => $q1->id, 'option_text' => 'Docker', 'is_correct' => false]);

    // 4. Create another Question
    $q2 = \App\Models\Question::create([
        'quiz_id' => $quiz->id,
        'question_text' => 'What is the default database for new Laravel projects?'
    ]);

    \App\Models\Option::create(['question_id' => $q2->id, 'option_text' => 'MySQL', 'is_correct' => false]);
    \App\Models\Option::create(['question_id' => $q2->id, 'option_text' => 'SQLite', 'is_correct' => true]);
}
}

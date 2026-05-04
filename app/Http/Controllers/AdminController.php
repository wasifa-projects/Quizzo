<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function autoFill()
    {
        // Variety playlist: GK, Science, CS, Sports, Geography, History, Politics, Animals, Gadgets
        $categories = [9, 17, 18, 21, 22, 23, 24, 27, 30];
        $randomCategory = $categories[array_rand($categories)];

        $response = Http::get("https://opentdb.com/api.php?amount=10&category={$randomCategory}&type=multiple");
        
        if ($response->successful()) {
            $data = $response->json()['results'];
            $categoryName = $data[0]['category'];

            // Create Quiz with a fixed 5-minute limit logic 
            $quiz = Quiz::create([
                'title' => $categoryName . ' - ' . now()->format('M d'),
                'category' => $categoryName,
                'time_limit' => 5, // Locked to 5 mins
            ]);

            foreach ($data as $item) {
                $options = array_merge([$item['correct_answer']], $item['incorrect_answers']);
                shuffle($options);

                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => html_entity_decode($item['question']),
                    'option_a' => html_entity_decode($options[0]),
                    'option_b' => html_entity_decode($options[1]),
                    'option_c' => html_entity_decode($options[2]),
                    'option_d' => html_entity_decode($options[3]),
                    'correct_option' => $this->getLetter($options, $item['correct_answer']),
                ]);
            }

            return redirect()->route('dashboard')->with('success', "New $categoryName module added!");
        }

        return redirect()->back()->with('error', 'API failed to connect.');
    }

    public function destroy($id)
{
    $quiz = Quiz::findOrFail($id);
    $quiz->delete();
    return back()->with('success', 'Module deleted successfully.');
}

    public function clearAll()
    {
        $quizzes = Quiz::all();
        foreach ($quizzes as $quiz) {
            $quiz->questions()->delete();
            $quiz->delete();
        }
        return redirect()->route('dashboard')->with('success', 'All modules cleared!');
    }

    private function getLetter($options, $correct)
    {
        $index = array_search($correct, $options);
        return chr(97 + $index); // converts 0 to 'a', 1 to 'b', etc.
    }
}
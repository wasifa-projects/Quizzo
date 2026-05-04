<?php

namespace App\Http\Controllers;

use App\Models\Quiz; 
use App\Models\Score; // Added to fix "Class Score not found"
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // Added to fix "Class Auth not found"

class QuizController extends Controller
{
    /**
     * DASHBOARD: Display stats and available quizzes
     */
    public function index()
{
    $user = Auth::user();
    
    // 1. Get Recent Scores: ONLY for students. 
    // Admins get a blank collection so the "No records" box doesn't trigger.
    $recentScores = !$user->is_admin 
        ? Score::where('user_id', $user->id)->with('quiz')->latest()->take(5)->get()
        : collect(); 

    // 2. Logic for the 3 Stat Boxes
    if ($user->is_admin) {
        $statsData = Score::all();
    } else {
        $statsData = Score::where('user_id', $user->id)->get();
    }

    // 3. Calculate the values
    $totalTaken = $statsData->count();
    
    $totalPossiblePoints = $statsData->sum('total');
    $avgScore = ($totalTaken > 0 && $totalPossiblePoints > 0) 
        ? round(($statsData->sum('score') / $totalPossiblePoints) * 100)
        : 0;
        
    $bestScore = $statsData->max('score');

    // 4. Fetch all quizzes for the "Available Courses" section
    $quizzes = Quiz::all();

    return view('dashboard', compact(
        'recentScores', 
        'totalTaken', 
        'avgScore', 
        'bestScore',
        'quizzes'
    ));
}

    /**
     * DATABASE MODE: Shows a specific quiz
     */
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * SUBMIT MODE: Handles scoring and saving results
     */
    public function submit(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $answers = $request->input('answers', []);
        $scoreCount = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] == $question->correct_option) {
                $scoreCount++;
            }
        }

        // Save to Database
        auth()->user()->scores()->create([
            'quiz_id' => $quiz->id,
            'score' => $scoreCount,
            'total' => $totalQuestions,
        ]);

        return view('quizzes.results', [
            'quiz' => $quiz,
            'score' => $scoreCount,
            'totalQuestions' => $totalQuestions
        ]);
    }

    /**
     * ADMIN: Delete a single module (Fix for your "Clear" button request)
     */
    public function destroy($id)
    {
        // Only allow admins to delete
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return back()->with('success', 'Module deleted successfully.');
    }

    /**
     * ADMIN: Create Quiz View
     */
    public function create()
{
    return view('quizzes.create'); 
}

    /**
     * PRACTICE MODE: OpenTDB API Integration
     */
    public function startPractice()
    {
        $response = Http::get('https://opentdb.com/api.php', [
            'amount' => 10,
            'type' => 'multiple'
        ]);

        if ($response->successful()) {
            $questions = $response->json()['results'];
            return view('quizzes.practice', compact('questions'));
        }

        return back()->with('error', 'API is down, try again later.');
    }
    /**
 * ADMIN: Store Quiz and Questions
 */
public function store(Request $request)
{
    // 1. Validate the input
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|string',
        'questions' => 'required|array|min:1',
        'questions.*.text' => 'required|string',
        'questions.*.correct' => 'required|string',
        'questions.*.options' => 'required|array|min:2',
    ]);

    // 2. Create the Quiz
    $quiz = Quiz::create([
        'title' => $request->title,
        'category' => $request->category,
        'user_id' => auth()->id(),
    ]);

    // 3. Create the Questions
    foreach ($request->questions as $qData) {
        // CLEANING: Strip manual numbers like "1." from the text before saving
        $cleanText = preg_replace('/^\d+[\s\.]*/', '', $qData['text']);

        $quiz->questions()->create([
            'question_text' => $cleanText,
            'correct_option' => $qData['correct'],
            'options' => json_encode($qData['options']), // Store options as JSON
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Module created successfully!');
}
}
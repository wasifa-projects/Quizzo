<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController; // <--- 1. ADDED THIS
use Illuminate\Support\Facades\Route;
use App\Models\Quiz;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
  /*
|--------------------------------------------------------------------------
| Dashboard Route
|--------------------------------------------------------------------------
*/

// Replace your old Route::get('/dashboard', function () {...}) with this:
Route::get('/dashboard', [QuizController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    // --- Practice Mode (OpenTDB API) ---
    Route::get('/practice', [QuizController::class, 'startPractice'])->name('quiz.practice');

    // --- Profile Management ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- General Quiz Play Routes ---
    Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');

 /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('can:admin-only')->group(function () {
        // We are naming this 'admin.create' for absolute clarity
        Route::get('/quizzes/create', [QuizController::class, 'create'])->name('admin.create');
        Route::post('/quizzes/store', [QuizController::class, 'store'])->name('quiz.store');
        
        Route::delete('/quizzes/cleanup', [QuizController::class, 'cleanup'])->name('quiz.cleanup');
        Route::delete('/admin/quiz/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::post('/admin/clear-all', [AdminController::class, 'clearAll'])->name('admin.clear');
        
        // This matches the 'admin.autofill' used in the dashboard
        Route::get('/admin/sync', [AdminController::class, 'autoFill'])->name('admin.autofill');
        Route::get('/results', function () {
    return view('results');
})->name('results')->middleware(['auth']);
        
    });

});

require __DIR__.'/auth.php';
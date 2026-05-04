<x-app-layout>
    <style>
        body, .min-h-screen { background-color: #0f172a !important; color: white; }
        .result-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 50px;
            text-align: center;
        }
        .score-circle {
            width: 150px; height: 150px;
            border-radius: 50%;
            border: 8px solid #6366f1;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 30px;
            font-size: 3rem; font-weight: 900;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }
    </style>

    <div class="max-w-2xl mx-auto py-20 px-4">
        <div class="result-card">
            <h1 class="text-3xl font-black mb-2">Quiz Completed!</h1>
            <p class="text-slate-400 mb-10">{{ $quiz->title }}</p>

            <div class="score-circle">
                {{ $score }}<span class="text-xl text-slate-500">/{{ $totalQuestions }}</span>
            </div>

            @php $percentage = ($score / $totalQuestions) * 100; @endphp

            <h2 class="text-2xl font-bold mb-6">
                @if($percentage >= 80) Great Job! 🏆
                @elseif($percentage >= 50) Not Bad! 👍
                @else Better luck next time! 📚 @endif
            </h2>

            <div class="space-y-4">
                <a href="{{ route('dashboard') }}" class="block w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-2xl transition">
                    Back to Dashboard
                </a>
                <a href="{{ route('quiz.practice') }}" class="block w-full bg-white/10 hover:bg-white/20 text-white font-bold py-4 rounded-2xl transition">
                    Try Practice Mode
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
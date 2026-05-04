<x-app-layout>
    <style>
        .timer-glow {
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.8; }
            100% { opacity: 1; }
        }
        .option-card {
            transition: all 0.2s ease;
            border: 2px solid #f3f4f6;
        }
        .option-card:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
            transform: scale(1.01);
        }
        input[type="radio"]:checked + span {
            color: #2563eb;
            font-weight: 700;
        }
    </style>

    <div id="timer-bar" class="timer-glow" style="position: sticky; top: 0; z-index: 50; background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%); color: white; padding: 15px; text-align: center; font-weight: 900; font-size: 1.4rem; letter-spacing: 1px;">
        ⏱️ <span id="timer-clock">60</span>s REMAINING
    </div>

    <div class="py-12" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; font-weight: 900; color: #1e293b; margin-bottom: 0.5rem;">{{ $quiz->title }}</h2>
                <div style="display: inline-block; height: 4px; width: 60px; background: #3b82f6; border-radius: 2px;"></div>
            </div>

            <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST" id="quiz-form">
                @csrf
                @foreach($quiz->questions as $index => $question)
                    <div style="background: white; padding: 2rem; border-radius: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2.5rem; border: 1px solid #e2e8f0;">
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                            <span style="background: #3b82f6; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; flex-shrink: 0;">
                                {{ $index + 1 }}
                            </span>
                            <p style="font-size: 1.25rem; font-weight: 700; color: #334155; line-height: 1.4;">
                                {{ $question->question_text }}
                            </p>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($question->options as $option)
                                <label class="option-card" style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; border-radius: 1rem; cursor: pointer;">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required style="width: 1.2rem; height: 1.2rem; cursor: pointer; accent-color: #2563eb;">
                                    <span style="font-size: 1rem; color: #475569;">{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: white; width: 100%; padding: 1.25rem; border-radius: 1.25rem; font-weight: 800; font-size: 1.25rem; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4); transition: transform 0.2s;">
                    FINISH & SUBMIT
                </button>
            </form>
        </div>
    </div>

    <script>
        let timeLeft = 60;
        const timerClock = document.getElementById('timer-clock');
        const timerBar = document.getElementById('timer-bar');
        const quizForm = document.getElementById('quiz-form');

        const countdown = setInterval(() => {
            timeLeft--;
            timerClock.innerText = timeLeft;

            if (timeLeft <= 10) {
                timerBar.style.background = "linear-gradient(90deg, #991b1b 0%, #dc2626 100%)";
                timerBar.style.fontSize = "1.6rem";
            }

            if (timeLeft <= 0) {
                clearInterval(countdown);
                const radios = quizForm.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => radio.required = false);
                alert("Time's up!");
                quizForm.submit();
            }
        }, 1000);
    </script>
</x-app-layout>
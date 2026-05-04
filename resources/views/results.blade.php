<x-app-layout>
    <style>
        .result-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 2rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .confetti-text {
            background: linear-gradient(to right, #3b82f6, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
        }
        .btn-action {
            transition: all 0.2s ease;
            text-align: center;
            display: block;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }
        /* New Styles for Answer Sheet */
        .review-section {
            margin-top: 2rem;
            text-align: left;
            animation: slideUp 0.8s ease-out;
        }
        .answer-item {
            background: white;
            border-radius: 1.25rem;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #e2e8f0;
        }
        .correct-bg { border-left: 6px solid #10b981; }
        .wrong-bg { border-left: 6px solid #ef4444; }
    </style>

    <div class="py-12" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0e7ff 100%); min-height: 100vh;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <div class="result-card p-10 text-center border border-white">
                <div style="font-size: 5rem; margin-bottom: 1rem; animation: bounce 2s infinite;">🏆</div>

                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 2px;">
                    Quiz Finished!
                </h2>

                <div style="margin: 2rem 0;">
                    <p style="font-size: 1rem; color: #64748b; font-weight: 600;">YOUR FINAL SCORE</p>
                    <h1 style="font-size: 5rem; font-weight: 900; line-height: 1;" class="confetti-text">
                        {{ $score }} <span style="font-size: 2rem; color: #cbd5e1; -webkit-text-fill-color: #cbd5e1;">/ {{ $total }}</span>
                    </h1>
                </div>

                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 1.25rem; border: 1px solid #f1f5f9;">
                    @if($score == $total)
                        <p style="color: #059669; font-weight: 800; font-size: 1.25rem;">✨ PERFECT SCORE! ✨</p>
                    @elseif($score >= $total / 2)
                        <p style="color: #2563eb; font-weight: 800; font-size: 1.25rem;">Great Job! 👍</p>
                    @else
                        <p style="color: #dc2626; font-weight: 800; font-size: 1.25rem;">Keep practicing! 💪</p>
                    @endif
                </div>

                <div class="review-section">
                    <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 1.5rem; display: flex; items-center; gap: 10px;">
                        📝 Answer Sheet
                    </h3>
                    <div id="answer-sheet-container">
                        </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem;">
                    <a href="{{ route('quiz.show', $quizId) }}" class="btn-action" style="background: linear-gradient(to right, #2563eb, #3b82f6); color: white; padding: 1.25rem; border-radius: 1rem; font-weight: 800; text-decoration: none; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);">
                        🔄 TRY AGAIN
                    </a>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <a href="/dashboard" class="btn-action" style="background: #111827; color: white; padding: 1rem; border-radius: 1rem; font-weight: 700; text-decoration: none;">
                            🏠 DASHBOARD
                        </a>
                        <a href="/dashboard#leaderboard" class="btn-action" style="background: #ffffff; color: #475569; padding: 1rem; border-radius: 1rem; font-weight: 700; text-decoration: none; border: 2px solid #e2e8f0;">
                            📊 RANKINGS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Pull the data from LocalStorage (saved during the quiz)
            const quizData = JSON.parse(localStorage.getItem('quizSummary')) || [];
            const container = document.getElementById('answer-sheet-container');

            if (quizData.length === 0) {
                container.innerHTML = `<p style="color: #94a3b8; font-style: italic;">No review data available.</p>`;
                return;
            }

            quizData.forEach((item, index) => {
                const div = document.createElement('div');
                div.className = `answer-item ${item.isCorrect ? 'correct-bg' : 'wrong-bg'}`;
                
                div.innerHTML = `
                    <p style="font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                        ${index + 1}. ${item.question}
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.9rem;">
                        <span style="color: ${item.isCorrect ? '#059669' : '#dc2626'}; font-weight: 600;">
                            Your Answer: ${item.userAnswer} ${item.isCorrect ? '✅' : '❌'}
                        </span>
                        ${!item.isCorrect ? `
                            <span style="color: #64748b;">
                                • Correct: <span style="color: #2563eb; font-weight: 600;">${item.actualAnswer}</span>
                            </span>
                        ` : ''}
                    </div>
                `;
                container.appendChild(div);
            });
        });
    </script>

    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</x-app-layout>
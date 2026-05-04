<x-app-layout>
    <style>
        /* Matching your dark academic theme */
        body, .min-h-screen {
            background-color: #0f0a1e !important;
        }

        .quiz-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .question-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            color: white;
        }

        .option-btn {
            display: block;
            width: 100%;
            text-align: left;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 12px;
            margin-top: 10px;
            color: #cbd5e1;
            transition: all 0.3s ease;
        }

        .option-btn:hover {
            background: #5850ec;
            color: white;
            transform: translateX(5px);
        }

        .category-badge {
            background: #5850ec;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
        /* Styling for the Question Number Badge */
.q-badge {
    display: flex;
    align-items: center;
    justify-center;
    min-width: 3.5rem; /* Large enough for double digits */
    height: 3.5rem;
    background: rgba(99, 102, 241, 0.15); /* Indigo tint */
    border: 2px solid rgba(99, 102, 241, 0.4);
    border-radius: 12px;
    color: #818cf8; /* Light Indigo */
    font-size: 1.5rem; /* Big enough to match the question */
    font-weight: 900;
    box-shadow: 0 0 20px rgba(99, 102, 241, 0.1);
    flex-shrink: 0; /* Prevents it from getting squashed */
}
    </style>

    <div class="quiz-container max-w-4xl mx-auto px-4">
    <h1 class="text-white text-4xl font-black mb-12 tracking-tight">Practice Mode</h1>

   @foreach($questions as $index => $q)
    <div class="mb-12">
        <div class="mb-6">
            <h2 class="text-2xl md:text-4xl font-extrabold text-white leading-tight tracking-tight">
                {{ preg_replace('/^\d+/', '', $q['question'] ?? $q->question_text) }}
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-4">
            </div>
    </div>
@endforeach

    <div class="mt-12 mb-20 text-center">
        <button type="submit" class="submit-btn">
            Finish Practice
        </button>
    </div>
</div>
</x-app-layout>
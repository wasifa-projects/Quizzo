<x-app-layout>
<style>
    /* 1. Global Background & Dark Theme */
    body, .min-h-screen, main { 
        background-color: #0f172a !important; 
        color: #ffffff;
    }

    /* 2. Glassmorphism Card Container */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }

    /* 3. Catchy Yellow Category Heading */
    .category-label {
        color: #facc15 !important; 
        font-size: 1.1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 0.25rem;
        text-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
    }

    /* 4. Large Subject Title Heading */
    .subject-title {
        color: #ffffff !important;
        font-size: 2.75rem; 
        font-weight: 900;
        line-height: 1.1;
        letter-spacing: -1.5px;
        margin-bottom: 1rem;
    }

    /* 5. Timer Section */
    .time-label {
        color: #ffffff !important; 
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        opacity: 0.9;
    }

    #timer-display {
        font-family: 'Courier New', Courier, monospace;
        font-size: 2.2rem;
        font-weight: 900;
        color: #e1ff4d !important; 
        text-shadow: 0 0 20px rgba(255, 77, 77, 0.5);
        line-height: 1;
    }

    /* 6. Red Progress Bar */
    .progress-container {
        width: 100%; 
        height: 8px; 
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px; 
        margin-top: 15px; 
        overflow: hidden;
    }

    #timer-progress {
        width: 100%; 
        height: 100%;
        background: linear-gradient(90deg, #e7ff4d, #c7f43f);
        transition: width 1s linear;
    }

    /* 7. Quiz Options */
    .option-btn {
        display: block; 
        width: 100%; 
        text-align: left;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px; 
        border-radius: 15px; 
        margin-top: 12px;
        color: #e2e8f0 !important; 
        font-weight: 1000; 
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .option-btn:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: #6366f1;
        transform: translateX(5px);
    }

    input[type="radio"]:checked + .option-btn {
        background: #4f46e5 !important;
        border-color: #818cf8 !important;
        color: #ffffff !important;
        box-shadow: 0 0 20px rgba(79, 70, 229, 0.4);
    }
    
    .submit-btn {
        display: inline-block;
        background: #6366f1 !important;
        color: white !important;
        font-weight: 900;
        padding: 1.25rem 5rem;
        border-radius: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.5);
    }
    
    .submit-btn:hover {
        background: #4f46e5 !important;
        transform: translateY(-2px);
        box-shadow: 0 20px 30px -5px rgba(99, 102, 241, 0.6);
    }
</style>

<div class="max-w-4xl mx-auto py-10 px-4">
    <div class="glass-card mb-10">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-indigo-400 font-bold uppercase tracking-widest text-xs">{{ $quiz->category }}</span>
                <h1 class="text-3xl font-black text-white mt-1">{{ $quiz->title }}</h1>
            </div>
            <div class="text-right">
                <p class="time-label text-xs uppercase mb-1">Time Remaining</p>
                <div id="timer-display">05:00</div>
            </div>
        </div>
        <div class="progress-container">
            <div id="timer-progress"></div>
        </div>
    </div>

    <form action="{{ route('quiz.submit', $quiz->id) }}" method="POST" id="quiz-form" onsubmit="prepareAnswerSheet()">
        @csrf
        @foreach($quiz->questions as $index => $question)
            <div class="glass-card mb-8 question-container" 
                 data-q-text="{{ $question->question_text }}" 
                 data-correct="{{ $question->correct_answer }}">
                
                <div class="flex items-center mb-6">
                    <span class="w-8 h-8 flex items-center justify-center bg-indigo-600 rounded-lg text-sm font-bold mr-3 text-white">{{ $index + 1 }}</span>
                    <h2 class="text-xl font-bold text-white">{{ $question->question_text }}</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $letter)
                        @php $field = "option_" . $letter; @endphp
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="answers[{{ $question->id }}]" 
                                   value="{{ $letter }}" 
                                   data-option-text="{{ $question->$field }}"
                                   class="hidden peer" required>
                            <div class="option-btn">
                                <span class="uppercase mr-2 opacity-50">{{ $letter }}.</span> {{ $question->$field }}
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-12 mb-20 text-center">
            <button type="submit" class="submit-btn">
                SUBMIT QUIZ
            </button>
        </div>
    </form>
</div>

<script>
    // Timer Logic
    let duration = 300; 
    let totalSeconds = duration;
    const display = document.getElementById('timer-display');
    const progressBar = document.getElementById('timer-progress');

    const timerInterval = setInterval(() => {
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;
        display.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        let percentage = (totalSeconds / duration) * 100;
        progressBar.style.width = percentage + "%";

        if (totalSeconds <= 0) {
            clearInterval(timerInterval);
            prepareAnswerSheet(); // Capture what they have before auto-submit
            document.getElementById('quiz-form').submit();
        }
        totalSeconds--;
    }, 1000);

    /**
     * Logic to capture answers for the Results Page
     */
    function prepareAnswerSheet() {
        let quizSummary = [];
        const questionBlocks = document.querySelectorAll('.question-container');

        questionBlocks.forEach(block => {
            const questionText = block.getAttribute('data-q-text');
            const correctLetter = block.getAttribute('data-correct'); // Assumes 'a', 'b', etc.
            
            // Find the selected radio in this block
            const selectedRadio = block.querySelector('input[type="radio"]:checked');
            
            // Find the text of the correct option
            const correctOptionElement = block.querySelector(`input[value="${correctLetter}"]`);
            const correctText = correctOptionElement ? correctOptionElement.getAttribute('data-option-text') : correctLetter;

            if (selectedRadio) {
                const userLetter = selectedRadio.value;
                const userText = selectedRadio.getAttribute('data-option-text');

                quizSummary.push({
                    question: questionText,
                    userAnswer: userText,
                    actualAnswer: correctText,
                    isCorrect: userLetter.toLowerCase() === correctLetter.toLowerCase()
                });
            }
        });

        // Save to localStorage so results.blade.php can read it
        localStorage.setItem('quizSummary', JSON.stringify(quizSummary));
    }
</script>
</x-app-layout>
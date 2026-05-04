<x-app-layout>
    <style>
        .creator-card {
            background: white;
            border-radius: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .creator-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .input-focus:focus {
            border-color: #3b82f6;
            ring-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .step-badge {
            background: #eff6ff;
            color: #2563eb;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }
    </style>

    <div class="py-12" style="background-color: #f8fafc; min-height: 100vh;">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div style="margin-bottom: 3rem; text-align: center;">
                <h2 style="font-size: 2.25rem; font-weight: 900; color: #0f172a;">Quiz Creator Studio 🎨</h2>
                <p style="color: #64748b; margin-top: 0.5rem;">Build a challenge that tests the best minds.</p>
            </div>

            <form action="{{ route('quiz.store') }}" method="POST" id="quiz-form">
                @csrf
                
                <div class="creator-card p-8 mb-8">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
                        <span class="step-badge">Step 1</span>
                        <h3 style="font-weight: 800; color: #1e293b;">General Information</h3>
                    </div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem;">Quiz Title</label>
                    <input type="text" name="title" class="input-focus" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 0.75rem; padding: 1rem; font-size: 1.1rem;" placeholder="e.g. Advanced Laravel Architecture" required>
                </div>

                <div id="questions-list">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem; padding-left: 1rem;">
                        <span class="step-badge">Step 2</span>
                        <h3 style="font-weight: 800; color: #1e293b;">Questions & Answers</h3>
                    </div>

                    <div class="question-item creator-card p-8 mb-6">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <h4 class="q-number" style="font-weight: 800; color: #3b82f6;">Question #1</h4>
                        </div>

                        <input type="text" name="questions[0][text]" class="input-focus" style="width: 100%; border: 1.5px solid #cbd5e1; border-radius: 0.75rem; padding: 0.75rem; margin-bottom: 1.5rem;" placeholder="Type your question here..." required>
                        
                        <p style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.05em;">Options (Select the correct one)</p>
                        
                        <div style="display: grid; grid-template-columns: 1fr; gap: 0.75rem;">
                            @for($i=0; $i<4; $i++)
                            <div style="display: flex; align-items: center; gap: 1rem; background: #f8fafc; padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #e2e8f0;">
                                <input type="radio" name="questions[0][correct]" value="{{ $i }}" required style="width: 1.2rem; height: 1.2rem; accent-color: #2563eb;">
                                <input type="text" name="questions[0][options][]" placeholder="Option {{ $i+1 }}" style="background: transparent; border: none; width: 100%; font-size: 0.9rem; outline: none;" required>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 3rem; background: #1e293b; padding: 1.5rem; border-radius: 1.25rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                    <button type="button" id="add-btn" style="background: rgba(255,255,255,0.1); color: white; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: 0.2s;">
                        + Add Question
                    </button>
                    
                    <button type="submit" style="background: #3b82f6; color: white; padding: 0.75rem 2.5rem; border-radius: 0.75rem; font-weight: 900; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);">
                        PUBLISH QUIZ 🚀
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let qIndex = 1;
        document.getElementById('add-btn').addEventListener('click', function() {
            const container = document.getElementById('questions-list');
            const clone = document.querySelector('.question-item').cloneNode(true);
            
            clone.querySelector('.q-number').innerText = `Question #${qIndex + 1}`;
            
            clone.querySelectorAll('input').forEach(input => {
                if(input.type === 'text') input.value = '';
                if(input.type === 'radio') input.checked = false;
                input.name = input.name.replace(/questions\[\d+\]/, `questions[${qIndex}]`);
            });

            container.appendChild(clone);
            qIndex++;
            clone.scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</x-app-layout>
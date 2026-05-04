<x-app-layout>
    <style>
        /* Professional Deep Purple Theme */
        body {
            background-color: #1a1625 !important;
        }

        .main-container {
            background-color: #1a1625;
            min-height: 100vh;
            color: #ffffff;
        }

        /* Glassmorphism for Academic Cards */
        .academic-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .academic-card:hover {
            border-color: #7c3aed;
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        /* Professional Admin/User Banner */
        .hero-banner-small {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 2rem;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        /* Small, Professional Stat Badges */
        .stat-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.25rem;
            border-radius: 1.25rem;
            border-left: 4px solid #7c3aed;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #a78bfa;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 900;
            color: #ffffff;
        }

        .history-row {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }
        .history-row:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .module-btn {
            background: #ffffff;
            color: #1a1625;
            padding: 1.1rem;
            border-radius: 12px;
            font-weight: 900;
            font-size: 0.9rem;
            text-align: center;
            transition: all 0.2s ease;
            display: block;
            text-decoration: none;
        }

        .module-btn:hover {
            background: #a78bfa;
            color: #ffffff;
        }
    </style>

    <div class="py-12 main-container">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="hero-banner-small">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-2">
                        @if(auth()->user()->is_admin)
                            <span class="bg-yellow-400 text-black text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter">
                                Faculty Administrator
                            </span>
                        @else
                            <span class="bg-indigo-400 text-white text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-tighter">
                                Academic Student
                            </span>
                        @endif
                    </div>
                    
                    <h1 style="font-size: 2rem; font-weight: 900; letter-spacing: -1px; color: white;">
                        Welcome back, {{ auth()->user()->name }}!
                    </h1>
                    
                    <p style="opacity: 0.8; font-size: 0.9rem; margin-top: 4px;">
                        {{ auth()->user()->is_admin ? 'Manage academic modules and monitor student performance.' : 'Continue your self-paced learning journey today.' }}
                    </p>

                   @if(auth()->user()->is_admin)
    <div class="flex gap-4 mt-6">
        <a href="{{ route('admin.autofill') }}" class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white text-xs font-bold py-2 px-4 rounded-lg transition-all no-underline border border-white/10">
            🔄 Sync New Modules
        </a>
        <a href="{{ url('/quizzes/create') }}" class="bg-white/10 hover:bg-white/20 text-white text-xs font-bold py-2 px-4 rounded-lg transition-all no-underline border border-white/10">
            + Manual Entry
        </a>
    </div>
@endif
                </div>
            </div>

            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #10b981; padding: 1rem; border-radius: 12px; font-weight: 700;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="stat-box">
        <span class="stat-label">{{ auth()->user()->is_admin ? 'Global Attempts' : 'Total Attempts' }}</span>
        <span class="stat-value">{{ $totalTaken }}</span>
    </div>

    <div class="stat-box" style="border-left-color: #10b981;">
        <span class="stat-label">{{ auth()->user()->is_admin ? 'Global Avg. Accuracy' : 'Avg. Accuracy' }}</span>
        <span class="stat-value">{{ $avgScore }}%</span>
    </div>

    <div class="stat-box" style="border-left-color: #f59e0b;">
        <span class="stat-label">{{ auth()->user()->is_admin ? 'Top Score (All Time)' : 'Highest Score' }}</span>
        <span class="stat-value">{{ $bestScore ?? 0 }}</span>
    </div>
</div>
            <div class="pt-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 style="font-size: 1.5rem; font-weight: 800;">Available Courses</h3>
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('admin.clear') }}" method="POST" onsubmit="return confirm('Delete ALL modules?');">
                            @csrf
                            <button type="submit" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.6rem 1.2rem; border-radius: 12px; font-weight: 800; font-size: 0.8rem; border: 1px solid rgba(239, 68, 68, 0.2);">
                                🗑️ Clear Database
                            </button>
                        </form>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse(\App\Models\Quiz::all() as $quiz)
                        <div class="academic-card overflow-hidden">
                            <div style="height: 100px; background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(124,58,237,0.1) 100%); position: relative;">
                                <div style="position: absolute; bottom: -20px; right: 20px; background: #1a1625; padding: 10px; border-radius: 12px; border: 2px solid rgba(255,255,255,0.1);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            </div>

                            <div class="p-8 flex-grow flex flex-col">
                                <span class="stat-label" style="font-size: 0.65rem;">ACADEMIC MODULE</span>
                                <h4 style="font-size: 1.3rem; font-weight: 900; line-height: 1.2; margin-top: 0.5rem; margin-bottom: 1.5rem;">{{ $quiz->title }}</h4>
                                
                                <div class="flex items-center gap-2 mb-8" style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1rem;">
                                    <div style="background: rgba(124, 58, 237, 0.2); padding: 8px 12px; border-radius: 8px; font-weight: 800; color: #a78bfa;">
                                        {{ $quiz->questions->count() }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-white text-sm">Questions</span>
                                        <span class="text-slate-500 text-xs">Verified Content</span>
                                    </div>
                                </div>

                                <div class="academic-card overflow-hidden">
    <div class="mt-auto">
        @if(auth()->user()->is_admin)
            <div class="flex justify-between items-center px-4 pb-4">
                <form action="{{ route('admin.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete ONLY this module?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-400 p-2 rounded-lg bg-red-500/10 border border-red-500/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>

                <a href="{{ route('quiz.show', $quiz->id) }}" class="text-xs text-indigo-400 font-bold no-underline hover:underline">
                    Launch Preview
                </a>
            </div>
        @else
            <a href="{{ route('quiz.show', $quiz->id) }}" class="module-btn">
                START ACADEMIC MODULE
            </a>
        @endif
    </div>
</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-10 col-span-3">No courses available. Admin needs to sync data.</p>
                    @endforelse
                </div>
            </div>

@if(!auth()->user()->is_admin)
            <div class="mt-8">
                <h2 class="text-xl font-bold text-white mb-4">Recent Performance</h2>

                @if($recentScores->isEmpty())
                    <div class="flex items-center justify-center p-8 bg-[#1a1625] border border-white/10 rounded-2xl">
                        <p class="text-gray-400 text-sm">No academic records found. Complete a module to see progress.</p>
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach($recentScores as $score)
                            <div class="p-4 bg-white/5 border border-white/10 rounded-xl flex justify-between items-center">
                                <span class="text-white font-medium">{{ $score->quiz->title ?? 'Practice Quiz' }}</span>
                                <span class="text-indigo-400 font-bold">{{ $score->score }}%</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

    </div> {{-- Closes the inner container --}}
</div> {{-- Closes the outer wrapper --}}
</x-app-layout>
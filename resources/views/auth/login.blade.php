<x-guest-layout>
    <style>
        /* 1. KILL THE WHITE FRAME FORCED BY THE LAYOUT */
        .min-h-screen, 
        .bg-gray-100, 
        main, 
        div[class*="bg-white"],
        .py-12 { 
            background-color: #0f0a1e !important; 
            background-image: none !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* 2. TRANSPARENT GLASS CARD */
        .login-card {
            background: rgba(255, 255, 255, 0.03) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            padding: 45px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            margin: auto;
        }

        /* 3. LOGO & TITLES */
        .brand-logo {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            margin: 0 auto 20px auto;
            display: block;
        }

        .brand-title {
            color: #ffffff;
            font-size: 34px;
            font-weight: 900;
            letter-spacing: -1px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* 4. FORM GROUPING & SPACING */
        .form-group {
            margin-bottom: 25px;
        }

        .label-text {
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
            display: block;
        }

        .input-field {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            padding: 14px 16px !important;
            width: 100%;
            outline: none;
        }

        /* 5. ADMIN SHORTCUT BOX */
        .admin-shortcut {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 6. BUTTON & FOOTER */
        .btn-enter {
            background-color: #5850ec !important; 
            color: white !important;
            border-radius: 12px !important;
            padding: 16px !important;
            font-weight: 800 !important;
            width: 100%;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .footer-text {
            font-size: 13px;
            color: #64748b;
            font-weight: 700;
        }

        .link-indigo {
            color: #6366f1;
            text-decoration: none;
            font-weight: 800;
        }
    </style>

    <div class="min-h-screen flex flex-col justify-center items-center px-4">
        <div class="login-card">
            
            <img src="{{ asset('asset/quizzo-logo.png') }}" alt="Quizzo Logo" class="brand-logo">
            <h2 class="brand-title">QUIZZO</h2>

         @if ($errors->any())
    <div class="mb-6 p-4 bg-red-600 border border-red-500 rounded-xl">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-bold text-white">
                    Login Failed
                </p>
                <ul class="mt-1 list-disc list-inside text-xs text-white opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="label-text">Email Address</label>
                    <input type="email" name="email" class="input-field" placeholder="name@academy.com" required autofocus>
                </div>

                <div class="form-group">
                    <div class="flex justify-between items-center mb-2">
                        <label class="label-text" style="margin-bottom: 0;">Password</label>
                        <a href="{{ route('password.request') }}" class="link-indigo" style="font-size: 11px;">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                </div>

                <div class="flex items-center mb-6">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded bg-black border-gray-700 text-indigo-600 focus:ring-0" style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="remember_me" class="ml-2 text-xs font-bold text-white" style="cursor: pointer;">Save password</label>
                </div>

                <div class="admin-shortcut">
                    
                    <label class="flex items-center cursor-pointer">
                        
                        <input type="checkbox" name="is_admin" value="1" class="rounded border-gray-700 bg-gray-900 text-indigo-600 focus:ring-0">
                        <span class="mr-2 text-xs font-bold text-gray-400">Log in as Admin</span>
                    </label>
                </div>

                <button type="submit" class="btn-enter">
                    Enter Quizzo
                </button>

                <div class="mt-10 text-center pt-6 border-t border-slate-800">
                    <p class="footer-text">
                        Don't have a account? 
                        <a href="{{ route('register') }}" class="link-indigo ml-1">Register now</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
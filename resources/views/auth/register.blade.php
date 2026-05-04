<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzo - Create Account</title>
    <style>
        /* Base styles */
        body {
            background-color: #0f0a1e; /* Deep dark purple/black background */
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #ffffff;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .brand-logo-img {
            width: 80px; 
            height: auto;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.4); /* Glow effect */
            margin-bottom: 1rem;
        }

        h2 { margin-bottom: 5px; font-size: 28px; font-weight: 900; }
        p.subtitle { color: #b3b3b3; margin-bottom: 25px; font-size: 14px; }

        .form-group {
            text-align: left;
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            color: #a78bfa; /* Light Purple Label */
            font-weight: 700;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #fff;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #6366f1;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Admin Section Styling */
        .admin-access-box {
            margin-top: 25px;
            margin-bottom: 25px;
            padding: 15px;
            background: rgba(139, 92, 246, 0.1); /* Subtle purple tint */
            border: 1px dashed rgba(139, 92, 246, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .admin-text h4 {
            margin: 0;
            font-size: 14px;
            color: #facc15; /* Catchy Yellow */
            text-transform: uppercase;
            text-align: left;
        }

        .admin-text p {
            margin: 0;
            font-size: 11px;
            color: #888;
            text-align: left;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #6366f1;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background-color: #6366f1;
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-register:hover {
            background-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="logo-container">
            <img src="{{ asset('asset/quizzo-logo.png') }}" alt="Quizzo Logo" class="brand-logo-img">
        </div>

        <h2>Quizzo</h2>
        

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="e.g. Alex Johnson" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="alex@university.edu" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <div class="admin-access-box">
                <div class="admin-text">
                    <h4>Access as Admin</h4>
                    <p>Enable administrative privileges</p>
                </div>
                <input type="checkbox" name="is_admin" value="1" class="checkbox-custom">
            </div>

            <button type="submit" class="btn-register">REGISTER NOW</button>
        </form>
    </div>

</body>
</html>
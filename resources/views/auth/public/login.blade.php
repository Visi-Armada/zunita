<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YB Dato' Zunita Begum</title>
    
    <!-- McKinsey Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --mckinsey-navy: #0f1419;
            --mckinsey-blue: #1f4e79;
            --mckinsey-teal: #0078d4;
            --mckinsey-gold: #ffb900;
            --mckinsey-gray: #6e6e6e;
            --mckinsey-light-gray: #f3f2f1;
            --mckinsey-white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--mckinsey-navy);
            line-height: 1.6;
            background: linear-gradient(135deg, var(--mckinsey-light-gray) 0%, var(--mckinsey-white) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            padding: 3rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--mckinsey-gray);
            font-size: 1.125rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--mckinsey-navy);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--mckinsey-blue);
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
        }

        .btn-primary {
            background: var(--mckinsey-blue);
            color: white;
        }

        .btn-primary:hover {
            background: var(--mckinsey-navy);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--mckinsey-gray);
        }

        .register-link a {
            color: var(--mckinsey-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: var(--mckinsey-blue);
            text-decoration: none;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to your account</p>
        </div>

        <form method="POST" action="{{ route('public.login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
                @error('password') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>

        <div class="forgot-password">
            <a href="#">Forgot your password?</a>
        </div>

        <div class="register-link">
            Don't have an account? <a href="{{ route('public.register') }}">Create one here</a>
        </div>
    </div>
</body>
</html>
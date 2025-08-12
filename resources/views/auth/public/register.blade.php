<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - YB Dato' Zunita Begum</title>
    
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

        .register-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            padding: 3rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-title {
            font-family: 'Georgia', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--mckinsey-navy);
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
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

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 1rem;
        }

        .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--mckinsey-light-gray);
            border-radius: 4px;
            font-size: 1rem;
            background: white;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
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

        .btn-secondary {
            background: var(--mckinsey-gold);
            color: var(--mckinsey-navy);
        }

        .btn-secondary:hover {
            background: #e6a700;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--mckinsey-gray);
        }

        .login-link a {
            color: var(--mckinsey-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .required::after {
            content: " *";
            color: #dc2626;
        }

        @media (max-width: 768px) {
            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }
            
            .register-container {
                padding: 2rem;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1 class="register-title">Create Your Account</h1>
            <p class="register-subtitle">Join our community to access services and submit requests</p>
        </div>

        <form method="POST" action="{{ route('public.register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Personal Information -->
            <div class="form-group">
                <label class="form-label required">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                @error('name') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
                    @error('email') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label required">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="form-input" required>
                    @error('phone') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">IC Number</label>
                    <input type="text" name="ic_number" value="{{ old('ic_number') }}" class="form-input" required>
                    @error('ic_number') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label required">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-input" required>
                    @error('date_of_birth') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Occupation</label>
                    <input type="text" name="occupation" value="{{ old('occupation') }}" class="form-input">
                    @error('occupation') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label class="form-label required">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-input" required>
                @error('address') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Postcode</label>
                    <input type="text" name="postcode" value="{{ old('postcode') }}" class="form-input" required>
                    @error('postcode') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label required">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="form-input" required>
                    @error('city') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label required">State</label>
                    <select name="state" class="form-select" required>
                        <option value="">Select State</option>
                        <option value="Johor" {{ old('state') == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Kedah" {{ old('state') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                        <option value="Kelantan" {{ old('state') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                        <option value="Melaka" {{ old('state') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                        <option value="Negeri Sembilan" {{ old('state') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                        <option value="Pahang" {{ old('state') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                        <option value="Penang" {{ old('state') == 'Penang' ? 'selected' : '' }}>Penang</option>
                        <option value="Perak" {{ old('state') == 'Perak' ? 'selected' : '' }}>Perak</option>
                        <option value="Perlis" {{ old('state') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                        <option value="Selangor" {{ old('state') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Terengganu" {{ old('state') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                        <option value="Kuala Lumpur" {{ old('state') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Putrajaya" {{ old('state') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                        <option value="Labuan" {{ old('state') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                    </select>
                    @error('state') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Account Security -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Password</label>
                    <input type="password" name="password" class="form-input" required>
                    @error('password') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label required">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>

            <!-- Preferences -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label required">Preferred Language</label>
                    <select name="preferred_language" class="form-select" required>
                        <option value="malay" {{ old('preferred_language') == 'malay' ? 'selected' : '' }}>Bahasa Melayu</option>
                        <option value="english" {{ old('preferred_language') == 'english' ? 'selected' : '' }}>English</option>
                        <option value="chinese" {{ old('preferred_language') == 'chinese' ? 'selected' : '' }}>中文</option>
                        <option value="tamil" {{ old('preferred_language') == 'tamil' ? 'selected' : '' }}>தமிழ்</option>
                    </select>
                    @error('preferred_language') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Household Size</label>
                    <input type="number" name="household_size" value="{{ old('household_size') }}" class="form-input" min="1">
                    @error('household_size') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Consent -->
            <div class="checkbox-group">
                <input type="checkbox" name="consent_marketing" id="consent_marketing" {{ old('consent_marketing') ? 'checked' : '' }}>
                <label for="consent_marketing">I consent to receive marketing communications</label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" name="consent_data_sharing" id="consent_data_sharing" {{ old('consent_data_sharing') ? 'checked' : '' }}>
                <label for="consent_data_sharing">I consent to data sharing for service improvement</label>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('public.login') }}">Sign in here</a>
        </div>
    </div>
</body>
</html>
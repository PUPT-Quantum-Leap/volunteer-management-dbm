<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Join Us Today</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            display: inline-block;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px;
            height: 80px;
            border-radius: 16px;
        }

        h1 {
            color: black;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #9ca3af;
            font-size: 14px;
        }

        .form-card {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #9ca3af;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"],
        select {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            outline: none;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        input:focus,
        select:focus {
            border-color: #1877F2;
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.1);
        }

        .input-error {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1) !important;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: #9ca3af;
        }

        .toggle-password:hover {
            color: #6b7280;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #1877F2;
        }

        .checkbox-wrapper label {
            margin: 0;
            font-size: 14px;
            cursor: pointer;
            font-weight: 400;
        }

        .forgot-link {
            color: #1877F2;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: #166fe5;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #1877F2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(24, 119, 242, 0.3);
        }

        .submit-btn:hover {
            background-color: #166fe5;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(24, 119, 242, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .divider {
            position: relative;
            text-align: center;
            margin: 24px 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e5e7eb;
        }

        .divider span {
            position: relative;
            background-color: white;
            padding: 0 12px;
            color: #6b7280;
            font-size: 14px;
        }

        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .social-btn {
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .social-btn:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        .signup-link {
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            font-size: 14px;
        }

        .signup-link a {
            color: #1877F2;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            color: #166fe5;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        .text-danger {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }

        .small {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">
                <img src="{{ asset('assets/nlcomlogo.jpg') }}" alt="NLCom Logo">
            </div>
            <h1>Create Account</h1>
            <p class="subtitle">Join us and start your journey today</p>
        </div>

        <div class="form-card">
            <form id="signupForm" method="POST" action="{{ url('/signup') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0" style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="role">I am a *</label>
                    <div class="input-wrapper">
                        <select
                            id="role"
                            name="role"
                            required
                            class="{{ $errors->has('role') ? 'input-error' : '' }}"
                        >
                            <option value="">Select your role</option>
                            <option value="volunteer" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fullname">Full Name *</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <input
                            type="text"
                            id="fullname"
                            name="fullname"
                            placeholder="John Doe"
                            value="{{ old('fullname') }}"
                            required
                            class="{{ $errors->has('fullname') ? 'input-error' : '' }}"
                        />
                    </div>
                    @error('fullname')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            required
                            class="{{ $errors->has('email') ? 'input-error' : '' }}"
                        />
                    </div>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            class="{{ $errors->has('password') ? 'input-error' : '' }}"
                        />
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg id="eyeIcon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password *</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input
                            type="password"
                            id="confirm-password"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            required
                            class="{{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                        />
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="terms" name="terms" required {{ old('terms') ? 'checked' : '' }}>
                        <label for="terms">I agree to the Terms and Conditions</label>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Create Account</button>
            </form>

            <div class="signup-link">
                Already have an account? <a href="{{ url('/login') }}">Sign in</a>
            </div>
        </div>
    </div>

        <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Function to show styled error message
        function showFieldError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const wrapper = field.closest('.form-group');
            
            const existingError = wrapper.querySelector('.js-error');
            if (existingError) {
                existingError.remove();
            }

            field.classList.add('input-error');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger small js-error';
            errorDiv.textContent = message;
            wrapper.appendChild(errorDiv);
        }

        // Function to clear field errors
        function clearFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            const wrapper = field.closest('.form-group');
            const existingError = wrapper.querySelector('.js-error');
            
            if (existingError) {
                existingError.remove();
            }
            field.classList.remove('input-error');
        }

        // Real-time validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            let hasError = false;
            
            clearFieldError('password');
            clearFieldError('confirm-password');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                showFieldError('confirm-password', 'Passwords do not match!');
                hasError = true;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                showFieldError('password', 'Password must be at least 8 characters long!');
                hasError = true;
            }
            
            return !hasError;
        });

        // Email validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                showFieldError('email', 'Please enter a valid email address.');
            } else {
                clearFieldError('email');
            }
        });

        document.querySelectorAll('input, select').forEach(function(element) {
            element.addEventListener('input', function() {
                clearFieldError(this.id);
            });
        });
    </script>
</body>
</html>
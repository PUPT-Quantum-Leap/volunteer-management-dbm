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
            min-height: 100vh;
            background: white;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(251, 146, 60, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(251, 146, 60, 0.1) 0%, transparent 50%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 450px;
            width: 100%;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
            margin-bottom: 1.5rem;
        }

        .logo-container i {
            color: white;
            font-size: 2rem;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #6b7280;
            font-size: 1rem;
        }

        /* Social Buttons */
        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            background: white;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .social-btn:hover {
            border-color: #f97316;
            background: #fff7ed;
            color: #f97316;
        }

        .social-btn.facebook:hover {
            border-color: #111827;
            background: #f9fafb;
            color: #111827;
        }

        .social-btn i {
            font-size: 1.25rem;
        }

        /* Divider */
        .divider {
            position: relative;
            margin: 1.5rem 0;
            text-align: center;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #d1d5db;
        }

        .divider span {
            position: relative;
            background: white;
            padding: 0 1rem;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Form */
        form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 0.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        label .required {
            color: #f97316;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s;
            outline: none;
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        input[type="password"]:hover {
            border-color: #9ca3af;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #f97316;
        }

        .password-hint {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: #6b7280;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #f97316;
        }

        .checkbox-label {
            font-size: 0.875rem;
            color: #374151;
            line-height: 1.4;
        }

        .checkbox-label a {
            color: #f97316;
            font-weight: 600;
            text-decoration: underline;
        }

        .checkbox-label a:hover {
            color: #ea580c;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
            transition: all 0.3s;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
            transform: scale(1.02);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        /* Sign In Link */
        .signin-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .signin-link a {
            color: #f97316;
            font-weight: 600;
            text-decoration: underline;
            margin-left: 0.25rem;
        }

        .signin-link a:hover {
            color: #ea580c;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
        }

        .footer p {
            font-size: 0.75rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .footer i {
            color: #f97316;
        }

        /* Success Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            padding: 1rem;
            z-index: 1000;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.4s ease-out;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .success-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: #dcfce7;
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .success-icon i {
            color: #16a34a;
            font-size: 1.5rem;
        }

        .modal-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .modal-content p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .modal-btn {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            font-weight: 700;
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .modal-btn:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
        }

        /* Responsive */
        @media (max-width: 640px) {
            h1 {
                font-size: 2rem;
            }

            .logo-container {
                width: 70px;
                height: 70px;
            }

            .logo-container i {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-container">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Create Account</h1>
            <p class="subtitle">Join us and start your journey today</p>
        </div>

        <!-- Social Sign Up
        <div class="social-buttons">
            <button type="button" class="social-btn">
                <i class="fab fa-google"></i>
                <span>Continue with Google</span>
            </button>
            <button type="button" class="social-btn facebook">
                <i class="fab fa-facebook"></i>
                <span>Continue with Facebook</span>
            </button>
        </div> -->

        <!-- Divider -->
        <div class="divider">
            <span>Or sign up with email</span>
        </div>

        <!-- Sign Up Form -->
        <form method="POST" action="{{ url('/signup') }}">
            @csrf
            
            <!-- Role Selection -->
            <div class="form-group">
                <label for="role">
                    I am a <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <select 
                        id="role" 
                        name="role"
                        required
                        class="input-field"
                    >
                        <option value="">Select your role</option>
                        <option value="volunteer">Volunteer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>

            <!-- Full Name -->
            <div class="form-group">
                <label for="fullname">
                    Full Name <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        placeholder="John Doe"
                        required
                    />
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">
                    Email Address <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@example.com"
                        required
                    />
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">
                    Password <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                    />
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-toggle"></i>
                    </button>
                </div>
                <p class="password-hint">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirm-password">
                    Confirm Password <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        id="confirm-password" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        required
                    />
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm-password')">
                        <i class="fas fa-eye" id="confirm-password-toggle"></i>
                    </button>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="checkbox-group">
                <input 
                    id="terms" 
                    name="terms" 
                    type="checkbox" 
                    required
                />
                <label for="terms" class="checkbox-label">
                    I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">
                <span>Create Account</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <!-- Sign In Link -->
        <div class="signin-link">
            <span>Already have an account?</span>
            <a href="#">Sign in</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <i class="fas fa-shield-alt"></i>
                <span>Your information is safe and secure</span>
            </p>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="success-modal" class="modal">
        <div class="modal-content">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h3>Account Created!</h3>
            <p>Welcome aboard! Your account has been successfully created.</p>
            <button class="modal-btn" onclick="closeModal()">Get Started</button>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-toggle');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long!');
                return;
            }
            
            // Show success modal
            document.getElementById('success-modal').classList.add('show');
            
            // Reset form
            this.reset();
        });

        function closeModal() {
            document.getElementById('success-modal').classList.remove('show');
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Poll - Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-subtitle {
            font-size: 0.875rem;
            opacity: 0.95;
            margin-top: 0.25rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .btn-logout:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .btn-back {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .card {
            background: #2a2a2a;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid #3a3a3a;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: #999;
            margin-bottom: 2rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-error h3 {
            color: #fca5a5;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .alert-error ul {
            list-style: disc;
            padding-left: 1.5rem;
            color: #fca5a5;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .required {
            color: #ff6b35;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #333333;
            border: 1px solid #3a3a3a;
            border-radius: 0.5rem;
            color: #ffffff;
            font-size: 0.9375rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-input::placeholder {
            color: #666;
        }

        .form-help {
            font-size: 0.75rem;
            color: #999;
            margin-top: 0.375rem;
        }

        .options-container {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .option-row {
            display: flex;
            gap: 0.5rem;
        }

        .btn-add-option {
            margin-top: 0.75rem;
            padding: 0.625rem 1rem;
            background-color: transparent;
            color: #1877F2;
            border: 2px solid #1877F2;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-add-option:hover {
            background-color: rgba(24, 119, 242, 0.1);
            border-color: #1565C0;
            transform: translateY(-1px);
        }

        .btn-remove {
            padding: 0.625rem 0.875rem;
            background-color: transparent;
            color: #ef4444;
            border: 1px solid #ef4444;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .btn-remove:hover {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: #dc2626;
            transform: translateY(-1px);
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid #3a3a3a;
            margin-top: 1.5rem;
        }

        .btn-primary {
            flex: 1;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1565C0 0%, #1976D2 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(24, 119, 242, 0.4);
        }

        .btn-secondary {
            padding: 0.875rem 1.5rem;
            background: #e2e8f0;
            color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 0.9375rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
            color: #334155;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(100, 116, 139, 0.2);
        }
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #4a4a4a;
        }

        /* Light Mode Styles */
        .light-mode body {
            background-color: #f7fafc;
            color: #0f172a;
        }

        .light-mode .header {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.12);
        }

        .light-mode .card {
            background: #ffffff;
            border-color: #e6e6e6;
        }

        .light-mode .page-title,
        .light-mode .form-label {
            color: #0f172a;
        }

        .light-mode .page-subtitle,
        .light-mode .form-help {
            color: #64748b;
        }

        .light-mode .form-input {
            background-color: #ffffff;
            border-color: #e6e6e6;
            color: #0f172a;
        }

        .light-mode .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .light-mode .form-input::placeholder {
            color: #94a3b8;
        }

        .light-mode .btn-logout {
            background-color: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }

        .light-mode .btn-logout:hover {
            background-color: rgba(15, 23, 42, 0.08);
        }

        .light-mode .btn-primary {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .light-mode .btn-primary:hover {
            background: linear-gradient(135deg, #1565C0 0%, #1976D2 100%);
            box-shadow: 0 8px 25px rgba(24, 119, 242, 0.4);
        }

        .light-mode .btn-secondary {
            background: #e2e8f0;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .light-mode .btn-secondary:hover {
            background: #cbd5e1;
            color: #334155;
        }

        .light-mode .btn-add-option {
            color: #1877F2;
            border-color: #1877F2;
        }

        .light-mode .btn-add-option:hover {
            background-color: rgba(24, 119, 242, 0.1);
            border-color: #1565C0;
        }
            background-color: rgba(255, 107, 53, 0.05);
        }

        .light-mode .btn-remove {
            color: #ef4444;
            border-color: #ef4444;
        }

        .light-mode .btn-remove:hover {
            background-color: rgba(239, 68, 68, 0.05);
        }

        .light-mode .alert-error {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .light-mode .alert-error h3,
        .light-mode .alert-error ul {
            color: #dc2626;
        }

        .light-mode .required {
            color: #ff6b35;
        }

        .light-mode .btn-back {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .light-mode .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.25rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-plus-circle"></i>
                    Create New Poll
                </h1>
                <div class="header-subtitle">Add a new poll for volunteers</div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ url('/admin/dashboard#polls') }}" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Polls
                </a>
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="card">

            <h2 class="page-title">Poll Details</h2>
            <p class="page-subtitle">Fill in the information below to create a new poll</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <h3><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/polls/create') }}">
                @csrf

                <div class="form-group">
                    <label for="question" class="form-label">
                        Poll Question <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="question"
                        name="question"
                        value="{{ old('question') }}"
                        placeholder="e.g., What time works best for volunteer meetings?"
                        class="form-input"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="max_votes" class="form-label">
                        Maximum Votes (Optional)
                    </label>
                    <input
                        type="number"
                        id="max_votes"
                        name="max_votes"
                        value="{{ old('max_votes') }}"
                        placeholder="Leave empty for unlimited votes"
                        min="1"
                        class="form-input"
                    />
                    <p class="form-help"><i class="fas fa-info-circle"></i> Set a limit to close voting after a certain number of votes</p>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Poll Options <span class="required">*</span>
                    </label>
                    <div id="options-container" class="options-container">
                        <div class="option-row">
                            <input
                                type="text"
                                name="options[]"
                                value="{{ old('options.0') ?? '' }}"
                                placeholder="Option 1"
                                class="form-input"
                                required
                            />
                        </div>
                        <div class="option-row">
                            <input
                                type="text"
                                name="options[]"
                                value="{{ old('options.1') ?? '' }}"
                                placeholder="Option 2"
                                class="form-input"
                                required
                            />
                        </div>
                    </div>
                    <button
                        type="button"
                        onclick="addOption()"
                        class="btn-add-option"
                    >
                        <i class="fas fa-plus"></i> Add Another Option
                    </button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-check"></i> Create Poll
                    </button>
                    <a href="{{ url('/polls/manage') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let optionCount = 2;

        function addOption() {
            optionCount++;
            const container = document.getElementById('options-container');
            const div = document.createElement('div');
            div.className = 'option-row';
            div.innerHTML = `
                <input
                    type="text"
                    name="options[]"
                    placeholder="Option ${optionCount}"
                    class="form-input"
                    required
                />
                <button
                    type="button"
                    onclick="this.parentElement.remove()"
                    class="btn-remove"
                    title="Remove this option"
                >
                    <i class="fas fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
        }

        // Theme toggle
        const THEME_KEY = 'vms_admin_theme';
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        function applyTheme(theme) {
            if (theme === 'light') {
                document.documentElement.classList.add('light-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                document.documentElement.classList.remove('light-mode');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }

        (function() {
            try {
                const saved = localStorage.getItem(THEME_KEY);
                applyTheme(saved === 'light' ? 'light' : 'dark');
            } catch (e) {
                applyTheme('dark');
            }
        })();

        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                try {
                    const current = document.documentElement.classList.contains('light-mode') ? 'light' : 'dark';
                    const next = current === 'light' ? 'dark' : 'light';
                    localStorage.setItem(THEME_KEY, next);
                    applyTheme(next);
                } catch (e) {
                    // ignore
                }
            });
        }
    </script>
</body>
</html>

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
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .header {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 20px rgba(24, 119, 242, 0.3);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
            opacity: 0.1;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
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
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .content-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border-left-color: #42A5F5;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
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
            border-color: #1877F2;
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.1);
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
            background: #ffffff;
            color: #1e293b;
        }

        .light-mode .header {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.3);
        }

        .light-mode .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-color: rgba(24, 119, 242, 0.1);
            color: #1e293b;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.08);
        }

        .light-mode .content-card:hover {
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.15);
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

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
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
                <a href="#" class="btn btn-logout" onclick="event.preventDefault(); showLogoutModal();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Logout Confirmation Modal -->
            <div id="logout-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center;">
                <div style="background: white; color:#1e293b; border-radius:1.5rem; padding:2rem 2.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.3); max-width:350px; margin:auto; text-align:center;">
                    <h2 style="margin-bottom:1rem; font-size:1.25rem; font-weight:700;">Confirm Logout</h2>
                    <p style="margin-bottom:2rem;">Are you sure you want to logout?</p>
                    <div style="display:flex; gap:1rem; justify-content:center;">
                        <button type="button" class="btn btn-danger" onclick="hideLogoutModal()">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="confirmLogout()">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.volunteers') }}" class="nav-item">
            <i class="fas fa-users"></i>
            <span>Volunteers</span>
        </a>
        <a href="{{ route('admin.attendance') }}" class="nav-item">
            <i class="fas fa-calendar-check"></i>
            <span>Attendance</span>
        </a>
        <a href="{{ route('admin.performance') }}" class="nav-item">
            <i class="fas fa-star"></i>
            <span>Performance</span>
        </a>
        <a href="/polls/manage" class="nav-item">
            <i class="fas fa-poll"></i>
            <span>Polls</span>
        </a>
        <a href="{{ route('admin.org-chart') }}" class="nav-item">
            <i class="fas fa-sitemap"></i>
            <span>Organization Chart</span>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user-shield"></i>
            <span>User Management</span>
        </a>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="content-card">

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

    <script>
        function showLogoutModal() {
            document.getElementById('logout-modal').style.display = 'flex';
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').style.display = 'none';
        }
        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Polls</title>
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
        }

        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 1.75rem;
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

        .btn-primary {
            background-color: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e55a2b;
            transform: translateY(-1px);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #2a2a2a;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #3a3a3a;
            transition: all 0.3s;
        }

        .stat-card:hover {
            border-color: #ff6b35;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.2);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff6b35, #ff8c5a);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
        }

        .content-card {
            background: #2a2a2a;
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid #3a3a3a;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .poll-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .poll-card {
            background: #333333;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #3a3a3a;
            transition: all 0.3s;
        }

        .poll-card:hover {
            border-color: #ff6b35;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.15);
        }

        .poll-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .poll-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .poll-meta {
            font-size: 0.875rem;
            color: #999;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-danger {
            background-color: transparent;
            color: #ff6b35;
            border: 1px solid #ff6b35;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-danger:hover {
            background-color: rgba(255, 107, 53, 0.1);
        }

        .poll-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .option-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .option-label {
            color: #ffffff;
            font-weight: 500;
        }

        .option-votes {
            color: #999;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #1a1a1a;
            border-radius: 1rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b35, #ff8c5a);
            border-radius: 1rem;
            transition: width 0.3s ease;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #3a3a3a;
            margin-bottom: 1rem;
        }

        .empty-state-text {
            font-size: 1.125rem;
            color: #999;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.25rem;
            }

            .page-header-top {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .poll-header {
                flex-direction: column;
                gap: 1rem;
            }
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

        .light-mode .stat-card,
        .light-mode .content-card,
        .light-mode .poll-card {
            background: #ffffff;
            border-color: #e6e6e6;
            color: #0f172a;
        }

        .light-mode .stat-label,
        .light-mode .poll-meta {
            color: #475569;
        }

        .light-mode .stat-value,
        .light-mode .poll-title,
        .light-mode .page-title,
        .light-mode .option-label {
            color: #0f172a;
        }

        .light-mode .option-votes {
            color: #64748b;
        }

        .light-mode .progress-bar {
            background-color: #f1f5f9;
        }

        .light-mode .progress-fill {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
        }

        .light-mode .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .light-mode .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #15803d;
        }

        .light-mode .btn-logout {
            background-color: rgba(15, 23, 42, 0.06);
            color: #0f172a;
        }

        .light-mode .btn-logout:hover {
            background-color: rgba(15, 23, 42, 0.08);
        }

        .light-mode .btn-primary {
            background-color: #ff6b35;
            color: #ffffff;
        }

        .light-mode .btn-primary:hover {
            background-color: #e55a2b;
        }

        .light-mode .btn-danger {
            background-color: transparent;
            color: #ff6b35;
            border-color: #ff6b35;
        }

        .light-mode .btn-danger:hover {
            background-color: rgba(255, 107, 53, 0.1);
        }

        .light-mode .empty-state-icon {
            color: #cbd5e1;
        }

        .light-mode .empty-state-text {
            color: #64748b;
        }

        .light-mode .stat-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
        }

        .light-mode .poll-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-chart-pie"></i>
                    Admin Dashboard
                </h1>
                <div class="header-subtitle">Manage volunteer polls and surveys</div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-poll"></i>
                </div>
                <div class="stat-label">Total Polls</div>
                <div class="stat-value">{{ $polls->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <div class="stat-label">Total Votes</div>
                <div class="stat-value">{{ $polls->sum(function($poll) { return $poll->options->sum('votes'); }) }}</div>
            </div>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-top">
                <h2 class="page-title">
                    <i class="fas fa-list"></i>
                    All Polls
                </h2>
                <a href="{{ url('/polls/create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create New Poll
                </a>
            </div>
        </div>

        <!-- Content Card -->
        <div class="content-card">

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($polls->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="empty-state-text">No polls created yet</div>
                    <a href="{{ url('/polls/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Create your first poll
                    </a>
                </div>
            @else
                <div class="poll-list">
                    @foreach ($polls as $poll)
                        <div class="poll-card">
                            <div class="poll-header">
                                <div>
                                    <div class="poll-title">{{ $poll->question }}</div>
                                    <div class="poll-meta">
                                        <span>
                                            <i class="fas fa-chart-bar"></i>
                                            {{ $poll->options->sum('votes') }} total votes
                                        </span>
                                        @if ($poll->max_votes)
                                            <span>
                                                <i class="fas fa-lock"></i>
                                                Max: {{ $poll->max_votes }} votes
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <form method="POST" action="{{ url("/polls/{$poll->id}/delete") }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        onclick="return confirm('Are you sure you want to delete this poll?')"
                                        class="btn btn-danger"
                                    >
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>

                            <div class="poll-options">
                                @foreach ($poll->options as $option)
                                    @php
                                        $pct = $poll->options->sum('votes') > 0 ? round(($option->votes / $poll->options->sum('votes')) * 100) : 0;
                                    @endphp
                                    <div>
                                        <div class="option-row">
                                            <span class="option-label">{{ $option->text }}</span>
                                            <span class="option-votes">{{ $option->votes }} votes ({{ $pct }}%)</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>
        // Theme (dark / light) toggle
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

        // Initialize theme from localStorage (defaults to dark)
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
                    // ignore storage errors
                }
            });
        }
    </script>
</body>
</html>

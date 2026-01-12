<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Management</title>
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
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
            font-size: 1.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(24, 119, 242, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1565C0 0%, #1976D2 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(24, 119, 242, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }

        .btn-danger {
            background: transparent;
            color: #EF4444;
            border: 2px solid #EF4444;
        }

        .btn-danger:hover {
            background: #EF4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1877F2, #42A5F5, #667eea);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.2);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 50%, #667eea 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 8px 24px rgba(24, 119, 242, 0.3);
            position: relative;
        }

        .stat-icon::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, #1877F2, #42A5F5);
            border-radius: 1rem;
            z-index: -1;
            opacity: 0.3;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .stat-description {
            font-size: 0.875rem;
            color: #64748b;
            opacity: 0.8;
        }

        .card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 1rem;
            text-align: left;
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .progress-bar {
            width: 100%;
            height: 0.75rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
            border-radius: 0.375rem;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
        }

        .score-label {
            font-weight: 600;
            color: #10B981;
            font-size: 1.125rem;
        }

        .metric-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .metric-reliability {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .metric-punctuality {
            background-color: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .metric-quality {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .metric-leadership {
            background-color: rgba(139, 92, 246, 0.2);
            color: #8b5cf6;
        }

        .metric-teamwork {
            background-color: rgba(236, 72, 153, 0.2);
            color: #ec4899;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.25rem;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
        }

        .pagination .active {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border-color: #1877F2;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .score-range {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.25rem;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .close-btn {
            background: none;
            border: none;
            color: #64748b;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Light mode overrides - Facebook Blue Theme */
        .light-mode body {
            background: #ffffff;
            color: #1e293b;
        }

        .light-mode .header {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.3);
        }

        .light-mode .stat-card,
        .light-mode .card,
        .light-mode .poll-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-color: rgba(24, 119, 242, 0.1);
            color: #1e293b;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.08);
        }

        .light-mode .stat-card:hover,
        .light-mode .card:hover,
        .light-mode .poll-card:hover {
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.15);
        }

        .light-mode .stat-label,
        .light-mode .poll-meta,
        .light-mode .poll-option-stats,
        .light-mode .profile-label {
            color: #64748b;
        }

        .light-mode .stat-value,
        .light-mode .profile-value,
        .light-mode .poll-question,
        .light-mode .poll-option-text {
            color: #1e293b;
        }

        .light-mode .profile-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
            border-left-color: #1877F2;
        }

        .light-mode .form-input,
        .light-mode .form-select,
        .light-mode .form-textarea {
            background-color: rgba(255, 255, 255, 0.9);
            color: #1e293b;
            border-color: rgba(24, 119, 242, 0.2);
            backdrop-filter: blur(10px);
        }

        .light-mode .tab-button {
            color: #64748b;
            background: #ffffff;
            border-color: rgba(24, 119, 242, 0.1);
        }

        .light-mode .tab-button.active {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border-color: #1877F2;
        }

        .light-mode .tab-button:hover {
            color: #1877F2;
            background: #f8fafc;
            border-color: rgba(24, 119, 242, 0.2);
        }

        .light-mode .tabs {
            background: #ffffff;
            border-color: rgba(24, 119, 242, 0.1);
        }

        .light-mode .poll-bar {
            background: linear-gradient(135deg, rgba(24, 119, 242, 0.1) 0%, rgba(102, 126, 234, 0.1) 100%);
            border-color: rgba(24, 119, 242, 0.2);
        }

        .light-mode .alert {
            background: rgba(24, 119, 242, 0.05);
            color: #1e293b;
            border-color: rgba(24, 119, 242, 0.2);
        }

        .light-mode .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: #10B981;
        }

        .light-mode .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border-color: #EF4444;
        }

        /* Edit-profile / form specific fixes for light mode */
        .light-mode .form-label {
            color: #1e293b;
        }

        .light-mode .required {
            color: #EF4444;
        }

        .light-mode .btn {
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.2);
        }

        .light-mode .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .light-mode .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .light-mode .btn-primary,
        .light-mode .btn-success {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .light-mode .btn-primary:hover,
        .light-mode .btn-success:hover {
            background: linear-gradient(135deg, #1565C0 0%, #1976D2 100%);
            box-shadow: 0 8px 25px rgba(24, 119, 242, 0.4);
        }

        .light-mode .btn-danger {
            background: transparent;
            color: #EF4444;
            border: 2px solid #EF4444;
        }

        .light-mode .btn-danger:hover {
            background: #EF4444;
            color: #ffffff;
        }

        .light-mode .stat-value {
            background: linear-gradient(135deg, #1e293b, #334155);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .light-mode .checkbox-item {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(24, 119, 242, 0.2);
            color: #1e293b;
        }

        .light-mode .checkbox-item label {
            color: #1e293b;
        }

        .light-mode .checkbox-item input {
            accent-color: #1877F2;
        }

        .light-mode .form-input,
        .light-mode .form-select,
        .light-mode .form-textarea {
            background: rgba(255, 255, 255, 0.9);
            color: #1e293b;
            border-color: rgba(24, 119, 242, 0.2);
        }

        .light-mode .form-input:focus,
        .light-mode .form-select:focus,
        .light-mode .form-textarea:focus {
            box-shadow: 0 0 0 4px rgba(24, 119, 242, 0.1);
            border-color: #1877F2;
        }

        .light-mode .tabs {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .light-mode th {
            color: #64748b;
        }

        .light-mode td {
            color: #1e293b;
        }

        .light-mode .card-title {
            color: #1e293b;
        }

        .light-mode .modal-title {
            color: #1e293b;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-chart-line"></i>
                    Performance Management
                </h1>
                <p class="header-subtitle">Track and evaluate volunteer performance metrics</p>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme" onclick="toggleTheme()">
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
    </header>

    <script>
        function showLogoutModal() {
            document.getElementById('logout-modal').style.display = 'flex';
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').style.display = 'none';
        }
        function confirmLogout() {
            document.querySelector('form[action="{{ route('logout') }}"]').submit();
        }

        // Theme (dark / light) toggle -------------------------------------------------
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
        <a href="{{ route('admin.performance') }}" class="nav-item active">
            <i class="fas fa-chart-line"></i>
            <span>Performance</span>
        </a>
        <a href="{{ route('admin.polls') }}" class="nav-item">
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

    <!-- Main Content -->
    <div class="container">
        <!-- Performance Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Total Evaluations</div>
                <div class="stat-value">{{ $records->count() }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-label">Average Score</div>
                <div class="stat-value">{{ $records->count() > 0 ? round($records->avg('score'), 1) : '0.0' }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-label">Top Performers</div>
                <div class="stat-value">{{ $records->where('score', '>=', 90)->count() }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-label">Recent Evaluations</div>
                <div class="stat-value">{{ $records->where('created_at', '>=', now()->subDays(30))->count() }}</div>
            </div>
        </div>

        <!-- Add New Performance Record -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Record Performance Evaluation</h2>
            </div>

            <form method="POST" action="{{ route('admin.performance.record') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Volunteer</label>
                        <select name="volunteer_id" class="form-select" required>
                            <option value="">-- Select Volunteer --</option>
                            @foreach ($volunteers as $volunteer)
                                <option value="{{ $volunteer->id }}">{{ $volunteer->first_name }} {{ $volunteer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Metric</label>
                        <select name="metric_name" class="form-select" required>
                            <option value="">-- Select Metric --</option>
                            <option value="reliability">Reliability</option>
                            <option value="punctuality">Punctuality</option>
                            <option value="quality">Quality of Work</option>
                            <option value="leadership">Leadership</option>
                            <option value="teamwork">Teamwork</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Score (0-100)</label>
                        <input type="number" name="score" class="form-input" min="0" max="100" placeholder="75" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Evaluated By</label>
                        <input type="text" name="evaluated_by" class="form-input" placeholder="Your Name" value="{{ auth()->user()->name ?? '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Feedback</label>
                    <textarea name="feedback" class="form-textarea" rows="3" placeholder="Provide constructive feedback..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Evaluation
                    </button>
                </div>
            </form>
        </div>

        <!-- Performance Records Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Performance Evaluations</h2>
            </div>

            @if ($records->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Volunteer</th>
                            <th>Metric</th>
                            <th>Score</th>
                            <th>Progress</th>
                            <th>Feedback</th>
                            <th>Evaluated By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td>{{ $record->volunteer->first_name }} {{ $record->volunteer->last_name }}</td>
                                <td><span class="metric-badge metric-{{ $record->metric_name }}">{{ ucfirst($record->metric_name) }}</span></td>
                                <td><span class="score-label">{{ $record->score }}/100</span></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $record->score }}%"></div>
                                    </div>
                                    <div class="score-range">
                                        <span>0</span>
                                        <span>100</span>
                                    </div>
                                </td>
                                <td style="font-size: 0.875rem; color: #bbb;">{{ Str::limit($record->feedback ?? '—', 50) }}</td>
                                <td>{{ $record->evaluated_by ?? 'System' }}</td>
                                <td>{{ $record->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $records->links() }}
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No performance evaluations yet.</p>
            @endif
        </div>
    </div>
</body>
</html>

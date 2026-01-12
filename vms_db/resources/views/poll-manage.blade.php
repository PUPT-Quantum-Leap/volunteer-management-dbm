<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Polls</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 110px;
            height: calc(100vh - 110px);
            width: 250px;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            overflow-y: auto;
            z-index: 900;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1100;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(24, 119, 242, 0.4);
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .mobile-menu-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(24, 119, 242, 0.6);
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

        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .main-content {
            margin-left: 250px;
            margin-top: 110px;
        }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 110px;
            height: calc(100vh - 110px);
            width: 250px;
            background: rgba(15, 23, 42, 0.98);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            overflow-y: auto;
            z-index: 900;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
        }

        .sidebar.mobile-hidden {
            transform: translateX(-100%);
        }

        .mobile-menu-toggle {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1100;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(24, 119, 242, 0.4);
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .mobile-menu-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(24, 119, 242, 0.6);
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

        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .main-content {
            margin-left: 250px;
            margin-top: 110px;
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

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-color: #10b981;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-color: #ef4444;
        }

        .alert-info {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff8c5a;
            border-color: #ff6b35;
        }

        .poll-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .poll-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1.25rem;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .poll-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1877F2, #42A5F5, #667eea);
        }

        .poll-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.15);
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
            gap: 1.5rem;
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
            height: 10px;
            background-color: #1a1a1a;
            border-radius: 1rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1877F2 0%, #42A5F5 50%, #667eea 100%);
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

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
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
        .light-mode .content-card,
        .light-mode .poll-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-color: rgba(24, 119, 242, 0.1);
            color: #1e293b;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.08);
        }

        .light-mode .stat-card:hover,
        .light-mode .content-card:hover,
        .light-mode .poll-card:hover {
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.15);
        }

        .light-mode .stat-label,
        .light-mode .poll-meta {
            color: #64748b;
        }

        .light-mode .stat-value,
        .light-mode .poll-title,
        .light-mode .option-label {
            color: #1e293b;
        }

        .light-mode .option-votes {
            color: #64748b;
        }

        .light-mode .progress-bar {
            background-color: #f1f5f9;
        }

        .light-mode .progress-fill {
            background: linear-gradient(90deg, #1877F2, #42A5F5, #667eea);
        }

        .light-mode .stat-icon {
            background: linear-gradient(135deg, #1877F2, #42A5F5, #667eea);
        }

        .light-mode .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #15803d;
        }

        .light-mode .btn-logout {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .light-mode .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .light-mode .btn-primary {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .light-mode .btn-primary:hover {
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

        .light-mode .empty-state-icon {
            color: #cbd5e1;
        }

        .light-mode .empty-state-text {
            color: #64748b;
        }

        .light-mode .stat-card:hover {
            border-color: #1877F2;
            box-shadow: 0 8px 24px rgba(24, 119, 242, 0.2);
        }

        .light-mode .poll-card:hover {
            border-color: #1877F2;
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.15);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-chart-pie"></i>
                    Admin Dashboard
                </h1>
                <p class="header-subtitle">Manage volunteer polls and surveys</p>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
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
    </header>

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
        <a href="/polls/manage" class="nav-item active">
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
                                    @php($totalVotes = $poll->options->sum('votes'))
                                    @php($pct = $totalVotes > 0 ? round(($option->votes / $totalVotes) * 100) : 0)
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

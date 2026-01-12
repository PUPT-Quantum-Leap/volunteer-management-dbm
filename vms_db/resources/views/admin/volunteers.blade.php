<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Volunteers</title>
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

        .theme-toggle {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
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

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .search-input:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }

        .form-select {
            padding: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-select:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
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

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .badge-warning {
            background-color: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
        }

        .badge-danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .action-links {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .action-btn-view {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .action-btn-view:hover {
            background: rgba(16, 185, 129, 0.3);
            transform: translateY(-1px);
        }

        .action-btn-edit {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
        }

        .action-btn-edit:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: translateY(-1px);
        }

        .action-btn-delete {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .action-btn-delete:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-1px);
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

            .card-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .search-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .action-links {
                justify-content: center;
            }

            .pagination {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-users"></i>
                    Manage Volunteers
                </h1>
                <div class="header-subtitle">Manage and organize your volunteer team</div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="#" class="btn btn-logout" onclick="event.preventDefault(); showLogoutModal();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Logout Confirmation Modal -->
            <div id="logout-modal" class="modal">
                <div class="modal-content" style="max-width: 400px;">
                    <div class="modal-header">
                        <h2 class="modal-title">Confirm Logout</h2>
                        <button class="close-btn" onclick="hideLogoutModal()">&times;</button>
                    </div>
                    <div style="padding: 1rem 0; text-align: center;">
                        <i class="fas fa-sign-out-alt fa-3x" style="color: #EF4444; margin-bottom: 1rem;"></i>
                        <p style="color: #64748b; margin-bottom: 1.5rem;">Are you sure you want to logout from the admin panel?</p>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <button type="button" class="btn btn-danger" onclick="hideLogoutModal()">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="confirmLogout()">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        function showLogoutModal() {
            document.getElementById('logout-modal').classList.add('active');
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').classList.remove('active');
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
        <a href="{{ route('admin.volunteers') }}" class="nav-item active">
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
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Volunteers</h2>
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn btn-success" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add Volunteer
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="search-bar">
                <input type="text" class="search-input" placeholder="Search volunteers by name, email..." id="volunteer-search" onkeyup="searchVolunteers()">
                <select class="form-select" style="width: 200px;" id="area-filter" onchange="filterVolunteers()">
                    <option value="">All Areas</option>
                    <option value="logistics">Logistics</option>
                    <option value="media">Media</option>
                    <option value="finance">Finance</option>
                    <option value="operations">Operations</option>
                </select>
                <select class="form-select" style="width: 150px;" id="status-filter" onchange="filterVolunteers()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            @if ($volunteers->count() > 0)
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Area</th>
                                <th>Education</th>
                                <th>Lifegroup</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="volunteers-tbody">
                            @foreach ($volunteers as $volunteer)
                                <tr>
                                    <td>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</td>
                                    <td>{{ $volunteer->email }}</td>
                                    <td>{{ $volunteer->mobile }}</td>
                                    <td>{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</td>
                                    <td>{{ ucwords(str_replace('-', ' ', $volunteer->education)) }}</td>
                                    <td>{{ ucfirst($volunteer->lifegroup) }}</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <div class="action-links">
                                            <button class="action-btn action-btn-view" onclick="viewVolunteer({{ $volunteer->id }})">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button class="action-btn action-btn-edit" onclick="editVolunteer({{ $volunteer->id }})">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="action-btn action-btn-delete" onclick="deleteVolunteer({{ $volunteer->id }})">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $volunteers->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem; color: #64748b;">
                    <i class="fas fa-users fa-3x" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="font-size: 1.1rem; margin-bottom: 1rem;">No volunteers found</p>
                    <p style="font-size: 0.9rem;">Start by adding your first volunteer to the system.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- View Volunteer Modal -->
    <div id="view-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Volunteer Details</h2>
                <button class="close-btn" onclick="closeViewModal()">&times;</button>
            </div>
            <div id="view-content" style="padding: 1rem 0;">
                <!-- Content will be populated by JavaScript -->
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" class="btn btn-primary" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Add/Edit Volunteer Modal -->
    <div id="volunteer-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title">Add Volunteer</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="volunteer-form" style="padding: 1rem 0;">
                <input type="hidden" id="volunteer-id">
                <!-- Form content will be populated by JavaScript -->
            </form>
        </div>
    </div>

    <script>
        function deleteVolunteer(id) {
            if (confirm('Are you sure you want to delete this volunteer?')) {
                fetch(`/admin/volunteer/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = document.querySelector(`tr:has([onclick="deleteVolunteer(${id})"])`);
                        if (row) {
                            row.remove();
                        }
                        // Show success message
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message || 'Error deleting volunteer', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting volunteer', 'error');
                });
            }
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 0.5rem;
                color: white;
                font-weight: 500;
                z-index: 10000;
                animation: slideIn 0.3s ease-out;
                ${type === 'success' ? 'background-color: #10b981;' : 'background-color: #ef4444;'}
            `;
            notification.textContent = message;
            
            // Add animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease-out reverse';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 3000);
        }

        // Theme toggle functionality
        function toggleTheme() {
            const body = document.body;
            const themeIcon = document.querySelector('.theme-toggle i');

            body.classList.toggle('light-mode');
            const isLightMode = body.classList.contains('light-mode');

            // Update icon
            if (isLightMode) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('theme', 'light');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Check for saved theme preference or default to dark mode
        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = localStorage.getItem('theme') || 'dark';
            const themeIcon = document.querySelector('.theme-toggle i');

            if (currentTheme === 'light') {
                document.body.classList.add('light-mode');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            }
        });
    </script>
</body>
</html>

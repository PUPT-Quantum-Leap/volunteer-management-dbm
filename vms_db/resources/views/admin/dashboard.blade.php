<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #0f172a;
            color: #ffffff;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
            z-index: 1000;
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

        /* Navigation Sidebar */
        .sidebar {
            position: fixed;
            top: 5rem;
            left: 0;
            width: 260px;
            height: calc(100vh - 5rem);
            background: #1a2332;
            border-right: 1px solid #2d3e52;
            padding-top: 1rem;
            z-index: 100;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            color: #999;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background-color: #252e3f;
            color: #ff6b35;
            border-left-color: #ff6b35;
        }

        .nav-item.active {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff6b35;
            border-left-color: #ff6b35;
        }

        .nav-item i {
            font-size: 1.25rem;
            width: 24px;
        }

        .main-content {
            margin-left: 260px;
            padding-top: 5rem;
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
        }

        .btn-primary {
            background-color: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e55a2b;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #1a2332;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #2d3e52;
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
            color: #fff;
        }

        .card {
            background: #1a2332;
            border-radius: 1rem;
            border: 1px solid #2d3e52;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #2d3e52;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 1rem;
            text-align: left;
            color: #999;
            font-size: 0.875rem;
            font-weight: 600;
            border-bottom: 1px solid #2d3e52;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #2d3e52;
            color: #fff;
        }

        tr:hover {
            background-color: #252e3f;
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

        /* Light Mode Styles */
        .light-mode body {
            background-color: #f7fafc;
            color: #0f172a;
        }

        .light-mode .header {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.12);
        }

        .light-mode .sidebar {
            background: #ffffff;
            border-right-color: #e2e8f0;
        }

        .light-mode .nav-item {
            color: #64748b;
        }

        .light-mode .nav-item:hover {
            background-color: #f1f5f9;
            color: #3b82f6;
            border-left-color: #3b82f6;
        }

        .light-mode .nav-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border-left-color: #3b82f6;
        }

        .light-mode .stat-card,
        .light-mode .card {
            background: #ffffff;
            border-color: #e2e8f0;
        }

        .light-mode .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .light-mode .stat-label {
            color: #64748b;
        }

        .light-mode .stat-value,
        .light-mode .card-title,
        .light-mode td {
            color: #0f172a;
        }

        .light-mode th {
            color: #64748b;
            border-bottom-color: #e2e8f0;
        }

        .light-mode td {
            border-bottom-color: #e2e8f0;
        }

        .light-mode tr:hover {
            background-color: #f8fafc;
        }

        .light-mode .card-header {
            border-bottom-color: #e2e8f0;
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
        }

        .light-mode .btn-primary:hover {
            background-color: #e55a2b;
        }

        .light-mode .stat-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
        }

        .light-mode .badge-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .light-mode .badge-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .light-mode .badge-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .light-mode .alert-success {
            background-color: rgba(16, 185, 129, 0.05);
            color: #059669;
            border-color: #10b981;
        }

        .light-mode .alert-error {
            background-color: rgba(239, 68, 68, 0.05);
            color: #dc2626;
            border-color: #ef4444;
        }

        .light-mode .form-label {
            color: #0f172a;
        }

        .light-mode .form-input,
        .light-mode .form-select,
        .light-mode .form-textarea {
            background-color: #ffffff;
            border-color: #e2e8f0;
            color: #0f172a;
        }

        .light-mode .form-input:focus,
        .light-mode .form-select:focus,
        .light-mode .form-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid #2d3e52;
            background-color: #0f172a;
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .action-links {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .action-btn-view {
            background-color: #3b82f6;
            color: white;
        }

        .action-btn-view:hover {
            background-color: #2563eb;
        }

        .action-btn-edit {
            background-color: #f59e0b;
            color: white;
        }

        .action-btn-edit:hover {
            background-color: #d97706;
        }

        .action-btn-delete {
            background-color: #ef4444;
            color: white;
        }

        .action-btn-delete:hover {
            background-color: #dc2626;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #1a2332;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid #2d3e52;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #2d3e52;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .close-btn {
            background: none;
            border: none;
            color: #999;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: #fff;
        }

        .search-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-input {
            flex: 1;
            padding: 0.875rem;
            border: 1px solid #2d3e52;
            background-color: #0f172a;
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .page-hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
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
                    <i class="fas fa-chart-line"></i>
                    Admin Dashboard
                </h1>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <a href="#" class="nav-item active" onclick="showPage('dashboard')">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item" onclick="showPage('volunteers')">
            <i class="fas fa-users"></i>
            <span>Volunteers</span>
        </a>
        <a href="#" class="nav-item" onclick="showPage('attendance')">
            <i class="fas fa-calendar-check"></i>
            <span>Attendance</span>
        </a>
        <a href="#" class="nav-item" onclick="showPage('performance')">
            <i class="fas fa-star"></i>
            <span>Performance</span>
        </a>
        <a href="#" class="nav-item" onclick="showPage('polls')">
            <i class="fas fa-poll"></i>
            <span>Polls</span>
        </a>
        <a href="/org-chart" class="nav-item">
            <i class="fas fa-sitemap"></i>
            <span>Organization Chart</span>
        </a>
        <a href="#" class="nav-item" onclick="showPage('users')">
            <i class="fas fa-user-shield"></i>
            <span>User Management</span>
        </a>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Dashboard Page -->
            <div id="dashboard-page" class="page">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-label">Total Volunteers</div>
                        <div class="stat-value">{{ $stats['total_volunteers'] }}</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-value">{{ $stats['total_users'] }}</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-poll"></i>
                        </div>
                        <div class="stat-label">Active Polls</div>
                        <div class="stat-value">{{ $stats['total_polls'] }}</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-label">Avg Attendance Rate</div>
                        <div class="stat-value">{{ $stats['average_attendance_rate'] }}%</div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Recent Volunteers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentVolunteers as $volunteer)
                            <tr>
                                <td>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</td>
                                <td>{{ $volunteer->email }}</td>
                                <td>{{ ucfirst($volunteer->area) }}</td>
                                <td>{{ $volunteer->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Active Polls</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Poll Title</th>
                                <th>Responses</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activePolls as $poll)
                            <tr>
                                <td>{{ $poll->title }}</td>
                                <td>{{ $poll->responses_count ?? 0 }}</td>
                                <td><span class="badge badge-success">Active</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Top Performers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Area</th>
                                <th>Performance Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topPerformers as $performer)
                            <tr>
                                <td>{{ $performer->first_name }} {{ $performer->last_name }}</td>
                                <td>{{ ucfirst($performer->area) }}</td>
                                <td>{{ $performer->performance_score ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Volunteers Page -->
            <div id="volunteers-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Manage Volunteers</h2>
                        <button class="btn btn-primary" onclick="openModal('create')">
                            <i class="fas fa-plus"></i> Add Volunteer
                        </button>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search volunteers..." id="volunteer-search" onkeyup="searchVolunteers()">
                        <select class="form-select" style="width: 200px;" id="area-filter" onchange="filterVolunteers()">
                            <option value="">All Areas</option>
                            <option value="logistics">Logistics</option>
                            <option value="media">Media</option>
                            <option value="finance">Finance</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>

                    <table id="volunteers-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="volunteers-tbody">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Attendance Page -->
            <div id="attendance-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Attendance Records</h2>
                        <button class="btn btn-primary" onclick="openModal('attendance')">
                            <i class="fas fa-plus"></i> Record Attendance
                        </button>
                    </div>
                    <p style="text-align: center; color: #999; padding: 2rem;">Attendance management coming soon...</p>
                </div>
            </div>

            <!-- Performance Page -->
            <div id="performance-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Performance Evaluations</h2>
                        <button class="btn btn-primary" onclick="openModal('performance')">
                            <i class="fas fa-plus"></i> Add Evaluation
                        </button>
                    </div>
                    <p style="text-align: center; color: #999; padding: 2rem;">Performance tracking coming soon...</p>
                </div>
            </div>

            <!-- Polls Page -->
            <div id="polls-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Poll Management</h2>
                        <a href="/polls/create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Poll
                        </a>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search polls..." id="poll-search" onkeyup="searchPolls()">
                        <select class="form-select" style="width: 150px;" id="status-filter" onchange="filterPolls()">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <table id="polls-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Created</th>
                                <th>Responses</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="polls-tbody">
                            @foreach($activePolls as $poll)
                            <tr>
                                <td>{{ $poll->title }}</td>
                                <td>{{ $poll->created_at->format('M d, Y') }}</td>
                                <td>{{ $poll->responses_count ?? 0 }}</td>
                                <td><span class="badge badge-success">Active</span></td>
                                <td>
                                    <div class="action-links">
                                        <a href="/polls/manage" class="action-btn action-btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <button class="action-btn action-btn-edit" onclick="editPoll({{ $poll->id }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="action-btn action-btn-delete" onclick="deletePoll({{ $poll->id }})">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Org Chart Page -->
            <div id="orgchart-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Organization Chart</h2>
                        <button class="btn btn-primary" onclick="generateOrgChart()">
                            <i class="fas fa-sync"></i> Generate Chart
                        </button>
                    </div>
                    <div id="org-chart-container" style="padding: 2rem; text-align: center; color: #999;">
                        Click "Generate Chart" to create an automated organization chart based on volunteer data.
                    </div>
                </div>
            </div>

            <!-- Users Page -->
            <div id="users-page" class="page page-hidden">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">User Management</h2>
                        <button class="btn btn-primary" onclick="openModal('user')">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                    <p style="text-align: center; color: #999; padding: 2rem;">User management coming soon...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Create/Edit Volunteer -->
    <div id="volunteer-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modal-title">Add Volunteer</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="volunteer-form" onsubmit="saveVolunteer(event)">
                <input type="hidden" id="volunteer-id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-input" id="first-name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-input" id="last-name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="email" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Mobile</label>
                        <input type="tel" class="form-input" id="mobile" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Volunteer Area</label>
                        <select class="form-select" id="volunteer-area" required>
                            <option value="">Select Area</option>
                            <option value="logistics">Logistics</option>
                            <option value="media">Media</option>
                            <option value="finance">Finance</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea class="form-textarea" id="address"></textarea>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for View Volunteer -->
    <div id="view-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Volunteer Details</h2>
                <button class="close-btn" onclick="closeViewModal()">&times;</button>
            </div>
            <div id="view-content"></div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        let volunteers = [];
        let currentVolunteerId = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadVolunteers();
        });

        // Page Navigation
        function showPage(pageName) {
            document.querySelectorAll('.page').forEach(page => {
                page.classList.add('page-hidden');
            });
            document.getElementById(pageName + '-page').classList.remove('page-hidden');

            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.closest('.nav-item').classList.add('active');
        }

        // Load Volunteers
        function loadVolunteers() {
            const stored = localStorage.getItem('volunteers');
            if (stored) {
                volunteers = JSON.parse(stored);
            } else {
                volunteers = [
                    {id: 1, firstName: 'John', lastName: 'Doe', email: 'john@example.com', mobile: '09123456789', area: 'logistics', address: '123 Main St', status: 'active'},
                    {id: 2, firstName: 'Jane', lastName: 'Smith', email: 'jane@example.com', mobile: '09187654321', area: 'media', address: '456 Oak Ave', status: 'active'},
                    {id: 3, firstName: 'Mike', lastName: 'Johnson', email: 'mike@example.com', mobile: '09156789012', area: 'finance', address: '789 Pine Rd', status: 'active'}
                ];
            }
            renderVolunteers();
            updateStats();
        }

        // Render Volunteers Table
        function renderVolunteers(filtered = volunteers) {
            const tbody = document.getElementById('volunteers-tbody');
            tbody.innerHTML = '';

            filtered.forEach(v => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${v.firstName} ${v.lastName}</td>
                    <td>${v.email}</td>
                    <td>${v.area.charAt(0).toUpperCase() + v.area.slice(1)}</td>
                    <td>${v.mobile}</td>
                    <td><span class="badge badge-success">${v.status}</span></td>
                    <td>
                        <div class="action-links">
                            <button class="action-btn action-btn-view" onclick="viewVolunteer(${v.id})">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="action-btn action-btn-edit" onclick="editVolunteer(${v.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn action-btn-delete" onclick="deleteVolunteer(${v.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Search Volunteers
        function searchVolunteers() {
            const searchTerm = document.getElementById('volunteer-search').value.toLowerCase();
            const areaFilter = document.getElementById('area-filter').value;
            
            let filtered = volunteers.filter(v => {
                const matchesSearch = v.firstName.toLowerCase().includes(searchTerm) || 
                                    v.lastName.toLowerCase().includes(searchTerm) ||
                                    v.email.toLowerCase().includes(searchTerm);
                const matchesArea = !areaFilter || v.area === areaFilter;
                return matchesSearch && matchesArea;
            });
            
            renderVolunteers(filtered);
        }

        // Filter Volunteers
        function filterVolunteers() {
            searchVolunteers();
        }

        // Open Modal
        function openModal(mode, id = null) {
            const modal = document.getElementById('volunteer-modal');
            const title = document.getElementById('modal-title');
            
            if (mode === 'create') {
                title.textContent = 'Add Volunteer';
                document.getElementById('volunteer-form').reset();
                document.getElementById('volunteer-id').value = '';
            } else if (mode === 'edit' && id) {
                const volunteer = volunteers.find(v => v.id === id);
                if (volunteer) {
                    title.textContent = 'Edit Volunteer';
                    document.getElementById('volunteer-id').value = volunteer.id;
                    document.getElementById('first-name').value = volunteer.firstName;
                    document.getElementById('last-name').value = volunteer.lastName;
                    document.getElementById('email').value = volunteer.email;
                    document.getElementById('mobile').value = volunteer.mobile;
                    document.getElementById('volunteer-area').value = volunteer.area;
                    document.getElementById('address').value = volunteer.address || '';
                }
            }
            
            modal.classList.add('active');
        }

        // Close Modal
        function closeModal() {
            document.getElementById('volunteer-modal').classList.remove('active');
        }

        // Save Volunteer
        function saveVolunteer(e) {
            e.preventDefault();
            
            const id = document.getElementById('volunteer-id').value;
            const volunteer = {
                id: id ? parseInt(id) : Date.now(),
                firstName: document.getElementById('first-name').value,
                lastName: document.getElementById('last-name').value,
                email: document.getElementById('email').value,
                mobile: document.getElementById('mobile').value,
                area: document.getElementById('volunteer-area').value,
                address: document.getElementById('address').value,
                status: 'active'
            };

            if (id) {
                const index = volunteers.findIndex(v => v.id === parseInt(id));
                volunteers[index] = volunteer;
            } else {
                volunteers.push(volunteer);
            }

            localStorage.setItem('volunteers', JSON.stringify(volunteers));
            renderVolunteers();
            updateStats();
            closeModal();
        }

        // View Volunteer
        function viewVolunteer(id) {
            const volunteer = volunteers.find(v => v.id === id);
            if (volunteer) {
                const content = document.getElementById('view-content');
                content.innerHTML = `
                    <div style="display: grid; gap: 1rem;">
                        <div><strong>Name:</strong> ${volunteer.firstName} ${volunteer.lastName}</div>
                        <div><strong>Email:</strong> ${volunteer.email}</div>
                        <div><strong>Mobile:</strong> ${volunteer.mobile}</div>
                        <div><strong>Area:</strong> ${volunteer.area.charAt(0).toUpperCase() + volunteer.area.slice(1)}</div>
                        <div><strong>Address:</strong> ${volunteer.address || 'N/A'}</div>
                        <div><strong>Status:</strong> <span class="badge badge-success">${volunteer.status}</span></div>
                    </div>
                `;
                document.getElementById('view-modal').classList.add('active');
            }
        }

        // Close View Modal
        function closeViewModal() {
            document.getElementById('view-modal').classList.remove('active');
        }

        // Edit Volunteer
        function editVolunteer(id) {
            openModal('edit', id);
        }

        // Delete Volunteer
        function deleteVolunteer(id) {
            if (confirm('Are you sure you want to delete this volunteer?')) {
                volunteers = volunteers.filter(v => v.id !== id);
                localStorage.setItem('volunteers', JSON.stringify(volunteers));
                renderVolunteers();
                updateStats();
            }
        }

        // Update Stats
        function updateStats() {
            document.getElementById('total-volunteers').textContent = volunteers.length;
        }

        // Search Polls
        function searchPolls() {
            const searchTerm = document.getElementById('poll-search').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value;

            // For now, using activePolls from Blade template
            // In a real implementation, this would fetch from server
            let filtered = activePolls.filter(poll => {
                const matchesSearch = poll.title.toLowerCase().includes(searchTerm);
                const matchesStatus = !statusFilter || poll.status === statusFilter;
                return matchesSearch && matchesStatus;
            });

            renderPolls(filtered);
        }

        // Filter Polls
        function filterPolls() {
            searchPolls();
        }

        // Render Polls Table
        function renderPolls(filtered = activePolls) {
            const tbody = document.getElementById('polls-tbody');
            tbody.innerHTML = '';

            filtered.forEach(poll => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${poll.title}</td>
                    <td>${new Date(poll.created_at).toLocaleDateString()}</td>
                    <td>${poll.responses_count || 0}</td>
                    <td><span class="badge badge-success">Active</span></td>
                    <td>
                        <div class="action-links">
                            <a href="/polls/manage" class="action-btn action-btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button class="action-btn action-btn-edit" onclick="editPoll(${poll.id})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn action-btn-delete" onclick="deletePoll(${poll.id})">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Edit Poll
        function editPoll(id) {
            // Redirect to poll edit page
            window.location.href = `/polls/${id}/edit`;
        }

        // Delete Poll
        function deletePoll(id) {
            if (confirm('Are you sure you want to delete this poll?')) {
                // In a real implementation, this would make an AJAX call
                alert('Poll deletion functionality would be implemented here');
            }
        }

        // Generate Organization Chart
        function generateOrgChart() {
            const container = document.getElementById('org-chart-container');

            // Show loading state
            container.innerHTML = '<div style="text-align: center; padding: 2rem;"><i class="fas fa-spinner fa-spin"></i> Generating organization chart...</div>';

            // Simulate API call delay
            setTimeout(() => {
                // Mock organization chart data
                const orgData = {
                    name: "Executive Director",
                    children: [
                        {
                            name: "Operations Manager",
                            children: [
                                { name: "Logistics Coordinator", children: [] },
                                { name: "Event Coordinator", children: [] }
                            ]
                        },
                        {
                            name: "Media Manager",
                            children: [
                                { name: "Content Creator", children: [] },
                                { name: "Social Media Specialist", children: [] }
                            ]
                        },
                        {
                            name: "Finance Manager",
                            children: [
                                { name: "Accountant", children: [] },
                                { name: "Fundraising Coordinator", children: [] }
                            ]
                        }
                    ]
                };

                // Generate HTML representation of org chart
                container.innerHTML = `
                    <div style="overflow-x: auto;">
                        <div class="org-chart" style="min-width: 800px; padding: 2rem;">
                            ${generateOrgChartHTML(orgData)}
                        </div>
                    </div>
                    <div style="text-align: center; margin-top: 2rem;">
                        <button class="btn btn-secondary" onclick="exportOrgChart()">
                            <i class="fas fa-download"></i> Export Chart
                        </button>
                    </div>
                `;
            }, 2000);
        }

        // Generate HTML for organization chart
        function generateOrgChartHTML(node, level = 0) {
            const indent = level * 40;
            let html = `
                <div class="org-node" style="margin-left: ${indent}px; margin-bottom: 1rem;">
                    <div class="org-card" style="background: #1a2332; border: 1px solid #2d3e52; border-radius: 0.5rem; padding: 1rem; display: inline-block; min-width: 200px; text-align: center;">
                        <div style="font-weight: 600; color: #ff6b35;">${node.name}</div>
                        ${node.children && node.children.length > 0 ? '<div style="margin-top: 0.5rem; color: #999; font-size: 0.875rem;">' + node.children.length + ' direct reports</div>' : ''}
                    </div>
                </div>
            `;

            if (node.children && node.children.length > 0) {
                html += '<div class="org-children" style="position: relative;">';
                html += '<div class="org-connector" style="position: absolute; left: ' + (indent + 100) + 'px; top: -10px; width: 2px; height: 20px; background: #2d3e52;"></div>';

                node.children.forEach(child => {
                    html += generateOrgChartHTML(child, level + 1);
                });
                html += '</div>';
            }

            return html;
        }

        // Export Organization Chart
        function exportOrgChart() {
            alert('Organization chart export functionality would be implemented here. This could generate a PDF or image of the chart.');
        }

        // Theme toggle functionality
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

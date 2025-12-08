<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            background-color: #0f172a;
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

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #2d3e52;
            overflow-x: auto;
        }

        .tab-button {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            color: #999;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            margin-bottom: -2px;
            white-space: nowrap;
        }

        .tab-button.active {
            color: #ff6b35;
            border-bottom-color: #ff6b35;
        }

        .tab-button:hover {
            color: #ff8c5a;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
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

        .form-input, .form-select {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid #2d3e52;
            background-color: #0f172a;
            color: #fff;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-input:focus, .form-select:focus {
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

        .action-links a {
            color: #ff6b35;
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
        }

        .action-links a:hover {
            color: #ff8c5a;
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
            <div>
                <a href="{{ url('/logout') }}" class="btn btn-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Alerts -->
        @if ($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Error:</strong>
                    <ul style="margin-top: 0.5rem; margin-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Dashboard Stats -->
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

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('overview', event)">
                <i class="fas fa-home"></i> Overview
            </button>
            <button class="tab-button" onclick="switchTab('volunteers', event)">
                <i class="fas fa-users"></i> Volunteers
            </button>
            <button class="tab-button" onclick="switchTab('attendance', event)">
                <i class="fas fa-calendar-check"></i> Attendance
            </button>
            <button class="tab-button" onclick="switchTab('performance', event)">
                <i class="fas fa-star"></i> Performance
            </button>
            <button class="tab-button" onclick="switchTab('org-chart', event)">
                <i class="fas fa-sitemap"></i> Org Chart
            </button>
        </div>

        <!-- Overview Tab -->
        <div id="overview" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Volunteers</h2>
                </div>
                @if ($recentVolunteers->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Mobile</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentVolunteers as $volunteer)
                                <tr>
                                    <td>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</td>
                                    <td>{{ $volunteer->email }}</td>
                                    <td>{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</td>
                                    <td>{{ $volunteer->mobile }}</td>
                                    <td>
                                        <div class="action-links">
                                            <a href="{{ route('admin.volunteer.show', $volunteer->id) }}">View</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="text-align: center; color: #999; padding: 2rem;">No volunteers found.</p>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Top Performers</h2>
                </div>
                @if ($topPerformers->count() > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Volunteer</th>
                                <th>Average Score</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topPerformers as $record)
                                <tr>
                                    <td>{{ $record->volunteer->first_name }} {{ $record->volunteer->last_name }}</td>
                                    <td>{{ round($record->avg_score) }}/100</td>
                                    <td>
                                        @if ($record->avg_score >= 80)
                                            <span class="badge badge-success">Excellent</span>
                                        @elseif ($record->avg_score >= 60)
                                            <span class="badge badge-warning">Good</span>
                                        @else
                                            <span class="badge badge-danger">Needs Improvement</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="text-align: center; color: #999; padding: 2rem;">No performance data available.</p>
                @endif
            </div>
        </div>

        <!-- Volunteers Tab -->
        <div id="volunteers" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Manage Volunteers</h2>
                    <a href="{{ route('admin.volunteers') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Attendance Tab -->
        <div id="attendance" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Manage Attendance</h2>
                    <a href="{{ route('admin.attendance') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Performance Tab -->
        <div id="performance" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Manage Performance</h2>
                    <a href="{{ route('admin.performance') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <!-- Org Chart Tab -->
        <div id="org-chart" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Edit Organization Chart</h2>
                    <a href="{{ route('admin.org-chart') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName, evt) {
            const eventObj = evt || window.event;
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            document.getElementById(tabName).classList.add('active');
            try {
                const targetButton = eventObj.target.closest('.tab-button');
                if (targetButton) targetButton.classList.add('active');
            } catch (e) {
                // ignore
            }
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
            text-decoration: none;
        }

        .btn-logout {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
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
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .profile-item {
            padding: 1.25rem;
            background-color: #0f172a;
            border-radius: 0.75rem;
            border-left: 4px solid #ff6b35;
        }

        .profile-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .profile-value {
            font-size: 1rem;
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-user"></i>
                    Volunteer Details
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
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">{{ $volunteer->first_name }} {{ $volunteer->last_name }}</h2>
                <a href="{{ route('admin.volunteers') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="profile-grid">
                <div class="profile-item">
                    <div class="profile-label">Email</div>
                    <div class="profile-value">{{ $volunteer->email }}</div>
                </div>
                <div class="profile-item">
                    <div class="profile-label">Mobile</div>
                    <div class="profile-value">{{ $volunteer->mobile }}</div>
                </div>
                <div class="profile-item">
                    <div class="profile-label">Volunteer Area</div>
                    <div class="profile-value">{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</div>
                </div>
                <div class="profile-item">
                    <div class="profile-label">Education</div>
                    <div class="profile-value">{{ ucwords(str_replace('-', ' ', $volunteer->education)) }}</div>
                </div>
                <div class="profile-item">
                    <div class="profile-label">Birthdate</div>
                    <div class="profile-value">{{ $volunteer->birthdate->format('M d, Y') }}</div>
                </div>
                <div class="profile-item">
                    <div class="profile-label">Lifegroup</div>
                    <div class="profile-value">{{ ucfirst($volunteer->lifegroup) }}</div>
                </div>
            </div>
        </div>

        <!-- Attendance Records -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Attendance</h2>
            </div>

            @if ($attendance->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendance as $record)
                            <tr>
                                <td>{{ $record->attendance_date->format('M d, Y') }}</td>
                                <td>{{ $record->event_name }}</td>
                                <td>
                                    <span class="badge badge-success">{{ ucfirst($record->status) }}</span>
                                </td>
                                <td>{{ $record->notes ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No attendance records.</p>
            @endif
        </div>

        <!-- Performance Records -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Performance Evaluations</h2>
            </div>

            @if ($performance->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Score</th>
                            <th>Feedback</th>
                            <th>Evaluated By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($performance as $record)
                            <tr>
                                <td>{{ ucfirst($record->metric_name) }}</td>
                                <td>{{ $record->score }}/100</td>
                                <td>{{ $record->feedback ?? '—' }}</td>
                                <td>{{ $record->evaluated_by ?? 'System' }}</td>
                                <td>{{ $record->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No performance evaluations.</p>
            @endif
        </div>
    </div>
</body>
</html>

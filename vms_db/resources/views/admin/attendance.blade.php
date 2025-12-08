<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
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

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
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

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #e0e7ff;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            background-color: #0f172a;
            border: 1px solid #2d3e52;
            border-radius: 0.5rem;
            color: #ffffff;
            font-size: 0.875rem;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
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

        .badge-present {
            background-color: rgba(16, 185, 129, 0.2);
            color: #10b981;
        }

        .badge-absent {
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .badge-excused {
            background-color: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid #2d3e52;
            border-radius: 0.25rem;
            color: #e0e7ff;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }

        .pagination .active {
            background-color: #ff6b35;
            border-color: #ff6b35;
            color: white;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-check-circle"></i>
                    Attendance Management
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
        <!-- Add New Attendance Record -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Record Attendance</h2>
            </div>

            <form method="POST" action="{{ route('admin.attendance.record') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Volunteer</label>
                        <select name="volunteer_id" required>
                            <option value="">-- Select Volunteer --</option>
                            @foreach ($volunteers as $volunteer)
                                <option value="{{ $volunteer->id }}">{{ $volunteer->first_name }} {{ $volunteer->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Attendance Date</label>
                        <input type="date" name="attendance_date" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Event</label>
                        <input type="text" name="event_name" placeholder="e.g., Sunday Service" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" required>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="excused">Excused</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Optional notes..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Record Attendance
                    </button>
                </div>
            </form>
        </div>

        <!-- Attendance Records Table -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Attendance Records</h2>
            </div>

            @if ($records->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Volunteer</th>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td>{{ $record->volunteer->first_name }} {{ $record->volunteer->last_name }}</td>
                                <td>{{ $record->attendance_date->format('M d, Y') }}</td>
                                <td>{{ $record->event_name }}</td>
                                <td>
                                    @if ($record->status === 'present')
                                        <span class="badge badge-present">Present</span>
                                    @elseif ($record->status === 'absent')
                                        <span class="badge badge-absent">Absent</span>
                                    @else
                                        <span class="badge badge-excused">Excused</span>
                                    @endif
                                </td>
                                <td>{{ $record->notes ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $records->links() }}
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No attendance records yet.</p>
            @endif
        </div>
    </div>
</body>
</html>

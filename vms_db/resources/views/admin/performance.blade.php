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

        .progress-bar {
            width: 100%;
            height: 0.5rem;
            background-color: #2d3e52;
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: #ff6b35;
            border-radius: 0.25rem;
        }

        .score-label {
            font-weight: 600;
            color: #ff6b35;
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

        .score-range {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #999;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-star"></i>
                    Performance Management
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
        <!-- Add New Performance Record -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Record Performance Evaluation</h2>
            </div>

            <form method="POST" action="{{ route('admin.performance.record') }}">
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
                        <label class="form-label">Metric</label>
                        <select name="metric_name" required>
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
                        <input type="number" name="score" min="0" max="100" placeholder="75" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Evaluated By</label>
                        <input type="text" name="evaluated_by" placeholder="Your Name" value="{{ auth()->user()->name ?? '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Feedback</label>
                    <textarea name="feedback" rows="3" placeholder="Provide constructive feedback..."></textarea>
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
                                <td>{{ ucfirst($record->metric_name) }}</td>
                                <td><span class="score-label">{{ $record->score }}/100</span></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $record->score }}%"></div>
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

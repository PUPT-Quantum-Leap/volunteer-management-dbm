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

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .profile-item {
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            border-left: 4px solid #ff6b35;
            transition: all 0.3s ease;
        }

        .profile-item:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        .profile-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .profile-value {
            font-size: 1rem;
            color: #fff;
            font-weight: 500;
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

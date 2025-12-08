<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Chart Editor</title>
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

        .section-header {
            background-color: #0f172a;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .section-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #ff6b35;
        }

        .info-box {
            background-color: rgba(255, 107, 53, 0.1);
            border-left: 4px solid #ff6b35;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            color: #e0e7ff;
            font-size: 0.875rem;
        }

        .info-box i {
            color: #ff6b35;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-sitemap"></i>
                    Organization Chart Editor
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
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            Update the organization chart details below. These settings define the structure and management of your volunteer organization.
        </div>

        <div class="card">
            <form method="POST" action="{{ route('admin.org-chart.update') }}">
                @csrf
                @method('POST')

                <!-- Basic Information Section -->
                <div class="section-header">
                    <h3>
                        <i class="fas fa-list"></i>
                        Basic Information
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Organization Objective</label>
                        <input type="text" name="objective" value="{{ $orgChart->objective ?? '' }}" placeholder="e.g., Serve the community with excellence">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Date Established</label>
                        <input type="date" name="date" value="{{ isset($orgChart->date) ? $orgChart->date->format('Y-m-d') : '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Total Volunteers</label>
                        <input type="number" name="volunteers_count" value="{{ $orgChart->volunteers_count ?? '' }}" min="1" placeholder="0">
                    </div>
                </div>

                <!-- Leadership Section -->
                <div class="section-header">
                    <h3>
                        <i class="fas fa-users"></i>
                        Leadership Team
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Organization Leader</label>
                        <input type="text" name="leader_name" value="{{ $orgChart->leader_name ?? '' }}" placeholder="e.g., John Smith">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deputy Leader</label>
                        <input type="text" name="deputy_leader" value="{{ $orgChart->deputy_leader ?? '' }}" placeholder="e.g., Jane Doe">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Treasurer</label>
                        <input type="text" name="treasurer" value="{{ $orgChart->treasurer ?? '' }}" placeholder="e.g., Michael Johnson">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Secretary</label>
                        <input type="text" name="secretary" value="{{ $orgChart->secretary ?? '' }}" placeholder="e.g., Sarah Williams">
                    </div>
                </div>

                <!-- Teams Section -->
                <div class="section-header">
                    <h3>
                        <i class="fas fa-project-diagram"></i>
                        Teams & Divisions
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Planning Team Lead</label>
                        <input type="text" name="planning_team_lead" value="{{ $orgChart->planning_team_lead ?? '' }}" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purchasing Team Lead</label>
                        <input type="text" name="purchasing_team_lead" value="{{ $orgChart->purchasing_team_lead ?? '' }}" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Operations Team Lead</label>
                        <input type="text" name="operations_team_lead" value="{{ $orgChart->operations_team_lead ?? '' }}" placeholder="Name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Communications Team Lead</label>
                        <input type="text" name="communications_team_lead" value="{{ $orgChart->communications_team_lead ?? '' }}" placeholder="Name">
                    </div>
                </div>

                <!-- Operations Details -->
                <div class="section-header">
                    <h3>
                        <i class="fas fa-cogs"></i>
                        Operational Details
                    </h3>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Planning Method/Strategy</label>
                        <input type="text" name="planning" value="{{ $orgChart->planning ?? '' }}" placeholder="e.g., Quarterly planning sessions">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purchasing Policy</label>
                        <input type="text" name="purchasing" value="{{ $orgChart->purchasing ?? '' }}" placeholder="e.g., Competitive bidding required">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meeting Frequency</label>
                        <input type="text" name="meeting_frequency" value="{{ $orgChart->meeting_frequency ?? '' }}" placeholder="e.g., Monthly or Weekly">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Budget Cycle</label>
                        <input type="text" name="budget_cycle" value="{{ $orgChart->budget_cycle ?? '' }}" placeholder="e.g., Annual">
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="section-header">
                    <h3>
                        <i class="fas fa-note-sticky"></i>
                        Additional Information
                    </h3>
                </div>

                <div class="form-group">
                    <label class="form-label">Organization Notes/Description</label>
                    <textarea name="notes" rows="4" placeholder="Add any additional information about the organization...">{{ $orgChart->notes ?? '' }}</textarea>
                </div>

                <!-- Submit -->
                <div class="form-actions">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Organization Chart
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
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
            background-color: #1a1a1a;
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
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e55a2b;
            transform: translateY(-1px);
        }

        .btn-success {
            background-color: #ff6b35;
            color: white;
        }

        .btn-success:hover {
            background-color: #e55a2b;
        }

        .btn-danger {
            background-color: transparent;
            color: #ff6b35;
            border: 2px solid #ff6b35;
        }

        .btn-danger:hover {
            background-color: #ff6b35;
            color: white;
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
            background: #2a2a2a;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid #3a3a3a;
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
            border-bottom: 2px solid #3a3a3a;
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
            background: #2a2a2a;
            border-radius: 1rem;
            border: 1px solid #3a3a3a;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #3a3a3a;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .profile-item {
            padding: 1.25rem;
            background-color: #1a1a1a;
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
            word-break: break-word;
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
            border: 1px solid #3a3a3a;
            background-color: #1a1a1a;
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

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background-color: #1a1a1a;
            border-radius: 0.5rem;
            border: 1px solid #3a3a3a;
            transition: all 0.2s;
        }

        .checkbox-item:hover {
            border-color: #ff6b35;
        }

        .checkbox-item input {
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: #ff6b35;
        }

        .checkbox-item label {
            cursor: pointer;
            margin: 0;
            color: #fff;
        }

        .poll-card {
            background: #2a2a2a;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            border: 1px solid #3a3a3a;
            transition: all 0.3s;
        }

        .poll-card:hover {
            border-color: #ff6b35;
            box-shadow: 0 8px 24px rgba(255, 107, 53, 0.15);
        }

        .poll-question {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }

        .poll-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #999;
            margin-bottom: 1.5rem;
        }

        .poll-option {
            margin-bottom: 1.25rem;
        }

        .poll-option-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .poll-option-text {
            font-weight: 500;
            color: #fff;
        }

        .poll-option-stats {
            font-size: 0.75rem;
            color: #999;
        }

        .poll-bar {
            width: 100%;
            height: 2rem;
            background-color: #1a1a1a;
            border-radius: 0.5rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            border: 1px solid #3a3a3a;
        }

        .poll-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b35, #ff8c5a);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            transition: width 0.5s ease;
        }

        .poll-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
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
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff8c5a;
            border-color: #ff6b35;
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border-color: #ef4444;
        }

        .alert-info {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff8c5a;
            border-color: #ff6b35;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .required {
            color: #ff6b35;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .profile-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .tabs {
                flex-wrap: wrap;
            }
        }
        /* Light mode overrides */
        .light-mode body {
            background-color: #f7fafc;
            color: #0f172a;
        }

        .light-mode .header {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59,130,246,0.12);
        }

        .light-mode .stat-card,
        .light-mode .card,
        .light-mode .poll-card {
            background: #ffffff;
            border-color: #e6e6e6;
            color: #0f172a;
        }

        .light-mode .stat-label,
        .light-mode .poll-meta,
        .light-mode .poll-option-stats,
        .light-mode .profile-label {
            color: #475569;
        }

        .light-mode .stat-value,
        .light-mode .profile-value,
        .light-mode .poll-question,
        .light-mode .poll-option-text {
            color: #0f172a;
        }

        .light-mode .profile-item {
            background-color: #ffffff;
            border-left-color: #3b82f6;
        }

        .light-mode .form-input,
        .light-mode .form-select,
        .light-mode .form-textarea {
            background-color: #ffffff;
            color: #0f172a;
            border-color: #e6e6e6;
        }

        .light-mode .tab-button {
            color: #64748b;
            border-bottom-color: transparent;
        }

        .light-mode .tab-button.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .light-mode .poll-bar {
            background-color: #f1f5f9;
            border-color: #e6e6e6;
        }

        .light-mode .alert {
            background-color: #f8fafc;
            color: #0f172a;
            border-color: #dbeafe;
        }
        /* Edit-profile / form specific fixes for light mode */
        .light-mode .form-label {
            color: #0f172a;
        }

        .light-mode .required {
            color: #ff6b35;
        }

        .light-mode .btn {
            box-shadow: none;
            color: inherit;
        }

        .light-mode .btn-logout {
            background-color: rgba(15,23,42,0.06);
            color: #0f172a;
        }

        .light-mode .btn-logout:hover {
            background-color: rgba(15,23,42,0.08);
        }

        .light-mode .btn-primary,
        .light-mode .btn-success {
            background-color: #ff6b35;
            color: #ffffff;
        }

        .light-mode .btn-primary:hover,
        .light-mode .btn-success:hover {
            background-color: #e55a2b;
        }

        .light-mode .btn-danger {
            background-color: transparent;
            color: #ff6b35;
            border-color: #ff6b35;
        }

        .light-mode .btn-danger:hover {
            background-color: #ff6b35;
            color: #ffffff;
        }

        .light-mode .checkbox-item {
            background-color: #ffffff;
            border-color: #e6e6e6;
            color: #0f172a;
        }

        .light-mode .checkbox-item label {
            color: #0f172a;
        }

        .light-mode .checkbox-item input {
            accent-color: #ff6b35;
        }

        .light-mode .form-input,
        .light-mode .form-select,
        .light-mode .form-textarea {
            background-color: #ffffff;
            color: #0f172a;
            border-color: #e6e6e6;
        }

        .light-mode .form-input:focus,
        .light-mode .form-select:focus,
        .light-mode .form-textarea:focus {
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
            border-color: #2563eb;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-hands-helping"></i>
                    Volunteer Dashboard
                </h1>
                <p class="header-subtitle">Manage your volunteer profile and participate in polls</p>
            </div>
            <div>
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
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
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="stat-label">Profile Status</div>
                <div class="stat-value">Active</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-poll"></i>
                </div>
                <div class="stat-label">Available Polls</div>
                <div class="stat-value">{{ count($polls) }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-label">Volunteer Area</div>
                <div class="stat-value" style="font-size: 1.25rem;">{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-label">Lifegroup</div>
                <div class="stat-value">{{ ucfirst($volunteer->lifegroup) }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-label">Attendance Rate</div>
                <div class="stat-value">{{ $attendanceRate }}%</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-label">Total Attendance</div>
                <div class="stat-value">{{ $attendanceStats['total'] }}</div>
            </div>
        </div>

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

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('profile', event)">
                <i class="fas fa-user"></i> My Profile
            </button>
            <button class="tab-button" onclick="switchTab('polls', event)">
                <i class="fas fa-poll"></i> Polls
            </button>
            <button class="tab-button" onclick="switchTab('attendance', event)">
                <i class="fas fa-calendar-check"></i> Attendance
            </button>
            <button class="tab-button" onclick="switchTab('performance', event)">
                <i class="fas fa-star"></i> Performance
            </button>
            <button class="tab-button" onclick="switchTab('edit', event)">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>

        <!-- Profile Tab -->
        <div id="profile" class="tab-content active">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Your Profile</h2>
                </div>
                <div class="profile-grid">
                    <div class="profile-item">
                        <div class="profile-label">First Name</div>
                        <div class="profile-value">{{ $volunteer->first_name }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Last Name</div>
                        <div class="profile-value">{{ $volunteer->last_name }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Email</div>
                        <div class="profile-value">{{ $volunteer->email }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Mobile</div>
                        <div class="profile-value">{{ $volunteer->mobile }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Birthdate</div>
                        <div class="profile-value">{{ $volunteer->birthdate->format('M d, Y') }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Education</div>
                        <div class="profile-value">{{ ucwords(str_replace('-', ' ', $volunteer->education)) }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Volunteer Area</div>
                        <div class="profile-value">{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Lifegroup</div>
                        <div class="profile-value">{{ ucfirst($volunteer->lifegroup) }}</div>
                    </div>
                    <div class="profile-item" style="grid-column: 1 / -1;">
                        <div class="profile-label">Address</div>
                        <div class="profile-value">{{ $volunteer->address }}</div>
                    </div>
                    <div class="profile-item" style="grid-column: 1 / -1;">
                        <div class="profile-label">Availability</div>
                        <div class="profile-value">{{ $volunteer->availability }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Polls Tab -->
        <div id="polls" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Available Polls</h2>
                </div>

                @forelse ($polls as $poll)
                    <div class="poll-card">
                        <div class="poll-question">{{ $poll['question'] }}</div>
                        <div class="poll-meta">
                            <span><i class="fas fa-vote-yea"></i> Total Votes: {{ $poll['total_votes'] }}</span>
                            @if ($poll['max_votes'])
                                <span><i class="fas fa-chart-bar"></i> Max Votes: {{ $poll['max_votes'] }} | Remaining: {{ max(0, $poll['max_votes'] - $poll['total_votes']) }}</span>
                            @endif
                        </div>

                        <div>
                            @foreach ($poll['options'] as $option)
                                <div class="poll-option">
                                    <div class="poll-option-header">
                                        <span class="poll-option-text">{{ $option['text'] }}</span>
                                        <span class="poll-option-stats">{{ $option['votes'] }} votes ({{ $poll['total_votes'] > 0 ? round(($option['votes'] / $poll['total_votes']) * 100) : 0 }}%)</span>
                                    </div>
                                    <div class="poll-bar">
                                        @if ($poll['total_votes'] > 0)
                                            <div class="poll-fill" style="width: {{ ($option['votes'] / $poll['total_votes']) * 100 }}%">
                                                {{ round(($option['votes'] / $poll['total_votes']) * 100) }}%
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="poll-buttons">
                            <form method="POST" action="{{ url('/api/polls/' . $poll['id'] . '/vote') }}" style="display: flex; gap: 0.75rem; align-items: center;">
                                @csrf
                                <select name="option_id" class="form-select" style="width: auto; min-width: 200px;">
                                    <option value="">Select an option...</option>
                                    @foreach ($poll['options'] as $option)
                                        <option value="{{ $option['id'] }}">{{ $option['text'] }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="volunteer_id" value="{{ $volunteer->id }}">
                                <button type="submit" class="btn btn-primary btn-small">
                                    <i class="fas fa-check"></i> Vote
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <span>No polls available at the moment.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Edit Profile Tab -->
        <div id="edit" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Edit Your Profile</h2>
                </div>

                <form method="POST" action="{{ url('/volunteer/' . $volunteer->id . '/update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name <span class="required">*</span></label>
                            <input type="text" name="first_name" class="form-input" value="{{ old('first_name', $volunteer->first_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name <span class="required">*</span></label>
                            <input type="text" name="last_name" class="form-input" value="{{ old('last_name', $volunteer->last_name) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $volunteer->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Mobile <span class="required">*</span></label>
                            <input type="tel" name="mobile" class="form-input" value="{{ old('mobile', $volunteer->mobile) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Facebook Name</label>
                            <input type="text" name="facebook_name" class="form-input" value="{{ old('facebook_name', $volunteer->facebook_name) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Birthdate <span class="required">*</span></label>
                            <input type="date" name="birthdate" class="form-input" value="{{ old('birthdate', $volunteer->birthdate->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Address <span class="required">*</span></label>
                        <textarea name="address" class="form-textarea" required>{{ old('address', $volunteer->address) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Education <span class="required">*</span></label>
                            <select name="education" class="form-select" required>
                                <option value="">Select your highest education</option>
                                <option value="elementary" {{ old('education', $volunteer->education) === 'elementary' ? 'selected' : '' }}>Elementary</option>
                                <option value="high-school" {{ old('education', $volunteer->education) === 'high-school' ? 'selected' : '' }}>High School</option>
                                <option value="college" {{ old('education', $volunteer->education) === 'college' ? 'selected' : '' }}>College</option>
                                <option value="graduate" {{ old('education', $volunteer->education) === 'graduate' ? 'selected' : '' }}>Graduate</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Volunteer Area <span class="required">*</span></label>
                            <select name="volunteer_area" class="form-select" required>
                                <option value="">Select a ministry or area</option>
                                <option value="childrens-ministry" {{ old('volunteer_area', $volunteer->volunteer_area) === 'childrens-ministry' ? 'selected' : '' }}>Children's Ministry</option>
                                <option value="youth-ministry" {{ old('volunteer_area', $volunteer->volunteer_area) === 'youth-ministry' ? 'selected' : '' }}>Youth Ministry</option>
                                <option value="worship-team" {{ old('volunteer_area', $volunteer->volunteer_area) === 'worship-team' ? 'selected' : '' }}>Worship Team</option>
                                <option value="media-production" {{ old('volunteer_area', $volunteer->volunteer_area) === 'media-production' ? 'selected' : '' }}>Media & Production</option>
                                <option value="hospitality" {{ old('volunteer_area', $volunteer->volunteer_area) === 'hospitality' ? 'selected' : '' }}>Hospitality & Ushering</option>
                                <option value="prayer-team" {{ old('volunteer_area', $volunteer->volunteer_area) === 'prayer-team' ? 'selected' : '' }}>Prayer Team</option>
                                <option value="outreach" {{ old('volunteer_area', $volunteer->volunteer_area) === 'outreach' ? 'selected' : '' }}>Community Outreach</option>
                                <option value="administrative" {{ old('volunteer_area', $volunteer->volunteer_area) === 'administrative' ? 'selected' : '' }}>Administrative Support</option>
                                <option value="facilities" {{ old('volunteer_area', $volunteer->volunteer_area) === 'facilities' ? 'selected' : '' }}>Facilities & Maintenance</option>
                                <option value="other" {{ old('volunteer_area', $volunteer->volunteer_area) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Training & Experience</label>
                        <textarea name="training" class="form-textarea" placeholder="List any relevant training...">{{ old('training', $volunteer->training) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Skills & Talents</label>
                        <textarea name="skills" class="form-textarea" placeholder="Share your skills...">{{ old('skills', $volunteer->skills) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Classes & Certifications</label>
                        <textarea name="classes" class="form-textarea" placeholder="List any classes...">{{ old('classes', $volunteer->classes) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Availability <span class="required">*</span></label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="weekdays-edit" name="availability[]" value="weekdays" {{ str_contains(old('availability', $volunteer->availability ?? ''), 'weekdays') ? 'checked' : '' }}>
                                <label for="weekdays-edit">Weekdays</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="weekends-edit" name="availability[]" value="weekends" {{ str_contains(old('availability', $volunteer->availability ?? ''), 'weekends') ? 'checked' : '' }}>
                                <label for="weekends-edit">Weekends</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="mornings-edit" name="availability[]" value="mornings" {{ str_contains(old('availability', $volunteer->availability ?? ''), 'mornings') ? 'checked' : '' }}>
                                <label for="mornings-edit">Mornings</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="afternoons-edit" name="availability[]" value="afternoons" {{ str_contains(old('availability', $volunteer->availability ?? ''), 'afternoons') ? 'checked' : '' }}>
                                <label for="afternoons-edit">Afternoons</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="evenings-edit" name="availability[]" value="evenings" {{ str_contains(old('availability', $volunteer->availability ?? ''), 'evenings') ? 'checked' : '' }}>
                                <label for="evenings-edit">Evenings</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Lifegroup Status <span class="required">*</span></label>
                            <select name="lifegroup" class="form-select" required>
                                <option value="yes" {{ old('lifegroup', $volunteer->lifegroup) === 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('lifegroup', $volunteer->lifegroup) === 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Emergency Contact Name <span class="required">*</span></label>
                            <input type="text" name="emergency_name" class="form-input" value="{{ old('emergency_name', $volunteer->emergency_name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Relationship <span class="required">*</span></label>
                            <input type="text" name="emergency_relation" class="form-input" value="{{ old('emergency_relation', $volunteer->emergency_relation) }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Emergency Phone <span class="required">*</span></label>
                            <input type="tel" name="emergency_phone" class="form-input" value="{{ old('emergency_phone', $volunteer->emergency_phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Emergency Email</label>
                            <input type="email" name="emergency_email" class="form-input" value="{{ old('emergency_email', $volunteer->emergency_email) }}">
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <button type="button" class="btn btn-danger" onclick="if(confirm('Delete this profile? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }">
                            <i class="fas fa-trash"></i> Delete Profile
                        </button>
                    </div>
                </form>

                <form id="delete-form" method="POST" action="{{ url('/volunteer/' . $volunteer->id . '/delete') }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <!-- Attendance Tab -->
        <div id="attendance" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Attendance Tracking</h2>
                </div>

                <!-- Attendance Summary Stats -->
                <div class="stats-grid" style="margin-bottom: 2rem;">
                    <div class="stat-card">
                        <div class="stat-label">Total Records</div>
                        <div class="stat-value">{{ $attendanceStats['total'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Present</div>
                        <div class="stat-value" style="color: #10b981;">{{ $attendanceStats['present'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Absent</div>
                        <div class="stat-value" style="color: #ef4444;">{{ $attendanceStats['absent'] }}</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Excused</div>
                        <div class="stat-value" style="color: #f59e0b;">{{ $attendanceStats['excused'] }}</div>
                    </div>
                </div>

                <!-- Attendance Rate Progress -->
                <div style="margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span class="form-label">Attendance Rate</span>
                        <span class="form-label" style="font-weight: 700;">{{ $attendanceRate }}%</span>
                    </div>
                    <div class="poll-bar" style="height: 2.5rem; border-radius: 1rem;">
                        <div class="poll-fill" style="width: {{ $attendanceRate }}%; border-radius: 1rem 0 0 1rem;">
                            {{ $attendanceRate }}%
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance Records -->
                @if ($attendanceRecords->count() > 0)
                    <div style="margin-top: 2rem;">
                        <h3 class="form-label" style="font-size: 1.1rem; margin-bottom: 1.5rem;">Recent Records</h3>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #3a3a3a;">
                                        <th style="padding: 1rem; text-align: left; color: #999; font-size: 0.875rem; font-weight: 600;">Date</th>
                                        <th style="padding: 1rem; text-align: left; color: #999; font-size: 0.875rem; font-weight: 600;">Event</th>
                                        <th style="padding: 1rem; text-align: left; color: #999; font-size: 0.875rem; font-weight: 600;">Status</th>
                                        <th style="padding: 1rem; text-align: left; color: #999; font-size: 0.875rem; font-weight: 600;">Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendanceRecords as $record)
                                        <tr style="border-bottom: 1px solid #3a3a3a;">
                                            <td style="padding: 1rem; color: #fff;">{{ $record->attendance_date->format('M d, Y') }}</td>
                                            <td style="padding: 1rem; color: #fff;">{{ $record->event_name ?? 'General' }}</td>
                                            <td style="padding: 1rem;">
                                                <span style="padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600;
                                                    @if ($record->status === 'present') background-color: rgba(16, 185, 129, 0.2); color: #10b981;
                                                    @elseif ($record->status === 'absent') background-color: rgba(239, 68, 68, 0.2); color: #ef4444;
                                                    @else background-color: rgba(245, 158, 11, 0.2); color: #f59e0b;
                                                    @endif
                                                ">
                                                    {{ ucfirst($record->status) }}
                                                </span>
                                            </td>
                                            <td style="padding: 1rem; color: #999; font-size: 0.875rem;">{{ $record->notes ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <span>No attendance records available yet.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Performance Tab -->
        <div id="performance" class="tab-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Performance Tracking</h2>
                </div>

                @if (count($performanceRecords) > 0)
                    <div class="stats-grid" style="margin-bottom: 2rem;">
                        @foreach ($performanceRecords as $metricName => $data)
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-{{ $metricName === 'reliability' ? 'shield-alt' : ($metricName === 'punctuality' ? 'clock' : 'thumbs-up') }}"></i>
                                </div>
                                <div class="stat-label">{{ ucfirst($metricName) }}</div>
                                <div class="stat-value">{{ $data['average'] }}/100</div>
                                <div style="font-size: 0.75rem; color: #999; margin-top: 0.5rem;">{{ $data['count'] }} evaluation{{ $data['count'] !== 1 ? 's' : '' }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Detailed Performance Records -->
                    <div style="margin-top: 2rem;">
                        <h3 class="form-label" style="font-size: 1.1rem; margin-bottom: 1.5rem;">Performance History</h3>
                        @foreach ($performanceRecords as $metricName => $data)
                            <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #1a1a1a; border-radius: 0.75rem; border-left: 4px solid #ff6b35;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <h4 style="font-size: 1rem; font-weight: 600; color: #fff; margin: 0;">{{ ucfirst($metricName) }}</h4>
                                    <div style="display: flex; gap: 1rem; font-size: 0.875rem;">
                                        <span style="color: #999;">Average: <strong style="color: #ff6b35;">{{ $data['average'] }}/100</strong></span>
                                        <span style="color: #999;">Latest: <strong style="color: #ff6b35;">{{ $data['latest']->score }}/100</strong></span>
                                    </div>
                                </div>

                                <!-- Score Bar -->
                                <div style="margin-bottom: 1rem;">
                                    <div class="poll-bar">
                                        <div class="poll-fill" style="width: {{ $data['average'] }}%; background: linear-gradient(90deg, #10b981, #14b8a6);">
                                        </div>
                                    </div>
                                </div>

                                <!-- Latest Feedback -->
                                @if ($data['latest']->feedback)
                                    <div style="background-color: #2a2a2a; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;">
                                        <div style="font-size: 0.875rem; color: #999; margin-bottom: 0.5rem;">Latest Feedback ({{ $data['latest']->created_at->format('M d, Y') }})</div>
                                        <div style="color: #fff; line-height: 1.6;">{{ $data['latest']->feedback }}</div>
                                        @if ($data['latest']->evaluated_by)
                                            <div style="font-size: 0.75rem; color: #666; margin-top: 0.5rem;">— {{ $data['latest']->evaluated_by }}</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <span>No performance evaluations available yet.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName, evt) {
            // support old-style global event if evt not provided
            const eventObj = evt || window.event;
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');
            try {
                const targetButton = eventObj.target.closest('.tab-button');
                if (targetButton) targetButton.classList.add('active');
            } catch (e) {
                // ignore
            }
        }

        // Validate availability checkboxes on edit form submit
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const availabilityChecked = this.querySelectorAll('input[name="availability[]"]:checked').length;
                if (availabilityChecked === 0 && this.querySelector('input[name="availability[]"]')) {
                    e.preventDefault();
                    alert('Please select at least one availability option.');
                }
            });
        });

        // Theme (dark / light) toggle -------------------------------------------------
        const THEME_KEY = 'vms_theme';
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
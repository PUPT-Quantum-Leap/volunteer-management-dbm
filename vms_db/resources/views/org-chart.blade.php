<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Organization Chart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-tabs {
            display: flex;
            background: #f8f8f8;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .nav-tab {
            padding: 15px 25px;
            cursor: pointer;
            border: none;
            background: transparent;
            border-bottom: 3px solid transparent;
            font-size: 16px;
            font-weight: 500;
            color: #666;
            transition: all 0.3s;
        }
        .nav-tab.active {
            color: #ff8c00;
            border-bottom-color: #ff8c00;
        }
        .nav-tab:hover {
            color: #ff6600;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .auto-assignments-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff8c00;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(255, 140, 0, 0.3);
            transition: all 0.3s;
        }
        .auto-assignments-btn:hover {
            background: #ff6600;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 140, 0, 0.4);
        }
    </style>
</head>
<body>
    <a href="{{ url('/auto-assignments') }}" class="auto-assignments-btn">
        Auto Assignments
    </a>

    <div class="nav-tabs">
        <button class="nav-tab active" onclick="showTab('org-chart')">Organization Chart</button>
        <button class="nav-tab" onclick="showTab('assignments')">Auto Assignments</button>
    </div>

    <div id="org-chart-tab" class="tab-content active">
        <div id="org-chart"></div>
    </div>

    <div id="assignments-tab" class="tab-content">
        <iframe src="{{ url('/auto-assignments') }}" style="width: 100%; height: 80vh; border: none;"></iframe>
    </div>

    <script>
        window.__ORG_CHART_DATA__ = @json($data);

        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>

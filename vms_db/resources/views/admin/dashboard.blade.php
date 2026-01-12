<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1877F2, #42A5F5, #667eea);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.2);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 50%, #667eea 100%);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: white;
            box-shadow: 0 8px 24px rgba(24, 119, 242, 0.3);
            position: relative;
        }

        .stat-icon::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, #1877F2, #42A5F5);
            border-radius: 1rem;
            z-index: -1;
            opacity: 0.3;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .stat-description {
            font-size: 0.875rem;
            color: #64748b;
            opacity: 0.8;
        }

        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 3rem;
            padding: 0.5rem;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow-x: auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .tab-button {
            padding: 1rem 2rem;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 0;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button.active {
            background: linear-gradient(135deg, #1877F2 0%, #42A5F5 100%);
            color: white;
            box-shadow: 0 4px 20px rgba(24, 119, 242, 0.3);
            transform: translateY(-2px);
        }

        .tab-button:hover {
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1rem;
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

        .alert-info {
            background-color: rgba(255, 107, 53, 0.1);
            color: #ff8c5a;
            border-color: #ff6b35;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #ffffff;
        }
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.875rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.05);
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
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 1.25rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .poll-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1877F2, #42A5F5, #667eea);
        }

        .poll-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 60px rgba(24, 119, 242, 0.15);
        }

        .poll-question {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1e293b;
            line-height: 1.3;
        }

        .poll-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 2rem;
            padding: 1rem;
            background: rgba(24, 119, 242, 0.05);
            border-radius: 0.75rem;
        }

        .poll-option {
            margin-bottom: 1.5rem;
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 0.75rem;
            border: 1px solid rgba(24, 119, 242, 0.1);
            transition: all 0.3s ease;
        }

        .poll-option:hover {
            background: rgba(24, 119, 242, 0.02);
            border-color: rgba(24, 119, 242, 0.2);
        }

        .poll-option-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .poll-option-text {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }

        .poll-option-stats {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        .poll-bar {
            width: 100%;
            height: 2.5rem;
            background: linear-gradient(135deg, rgba(24, 119, 242, 0.1) 0%, rgba(102, 126, 234, 0.1) 100%);
            border-radius: 0.75rem;
            overflow: hidden;
            display: flex;
            align-items: center;
            border: 2px solid rgba(24, 119, 242, 0.1);
            position: relative;
        }

        .poll-fill {
            height: 100%;
            background: linear-gradient(90deg, #1877F2 0%, #42A5F5 50%, #667eea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            font-weight: 700;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(24, 119, 242, 0.3);
            position: relative;
        }

        .poll-fill::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
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

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .required {
            color: #ff6b35;
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

        .nav-item.key {
            font-weight: 600;
            border-left-color: #ff6b35;
        }

        .nav-item.key:hover {
            border-left-color: #ff8c5a;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .page {
            display: none;
        }

        .page:not(.page-hidden) {
            display: block;
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

        /* Action Buttons */
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

        /* Search Bar */
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

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .tabs {
                flex-wrap: wrap;
            }

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Light mode overrides - Facebook Blue Theme */
        .light-mode body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
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
    </style>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-chart-line"></i>
                    Admin Dashboard
                </h1>
                <p class="header-subtitle">Manage volunteers, polls, and system analytics</p>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <button id="theme-toggle" class="btn btn-logout" title="Toggle dark / light mode" aria-label="Toggle theme">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>
                <a href="#" class="btn btn-logout" onclick="event.preventDefault(); showLogoutModal();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <!-- Logout Confirmation Modal -->
            <div id="logout-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.7); z-index:9999; align-items:center; justify-content:center;">
                <div style="background: white; color:#1e293b; border-radius:1.5rem; padding:2rem 2.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.3); max-width:350px; margin:auto; text-align:center;">
                    <h2 style="margin-bottom:1rem; font-size:1.25rem; font-weight:700;">Confirm Logout</h2>
                    <p style="margin-bottom:2rem;">Are you sure you want to logout?</p>
                    <div style="display:flex; gap:1rem; justify-content:center;">
                        <button type="button" class="btn btn-danger" onclick="hideLogoutModal()">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="confirmLogout()">Logout</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </header>
    <script>
        function showLogoutModal() {
            document.getElementById('logout-modal').style.display = 'flex';
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').style.display = 'none';
        }
        function confirmLogout() {
            document.querySelector('form[action="{{ route('logout') }}"]').submit();
        }
    </script>

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
            const tbody = document.getElementById('volunteers-tbody');
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 2rem;">Loading volunteers...</td></tr>';
            
            // Use real database data passed from Laravel
            volunteers = @json($allVolunteers);
            renderVolunteers();
            updateStats();
        }

        // Render Volunteers Table
        function renderVolunteers(filtered = volunteers) {
            const tbody = document.getElementById('volunteers-tbody');
            tbody.innerHTML = '';

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 2rem;">No volunteers found.</td></tr>';
                return;
            }

            filtered.forEach(v => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${v.first_name} ${v.last_name}</td>
                    <td>${v.email}</td>
                    <td>${v.volunteer_area ? v.volunteer_area.charAt(0).toUpperCase() + v.volunteer_area.slice(1) : 'N/A'}</td>
                    <td>${v.mobile || 'N/A'}</td>
                    <td><span class="badge badge-success">Active</span></td>
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
                const matchesSearch = v.first_name.toLowerCase().includes(searchTerm) || 
                                    v.last_name.toLowerCase().includes(searchTerm) ||
                                    v.email.toLowerCase().includes(searchTerm);
                const matchesArea = !areaFilter || v.volunteer_area === areaFilter;
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
                    document.getElementById('first-name').value = volunteer.first_name;
                    document.getElementById('last-name').value = volunteer.last_name;
                    document.getElementById('email').value = volunteer.email;
                    document.getElementById('mobile').value = volunteer.mobile;
                    document.getElementById('volunteer-area').value = volunteer.volunteer_area;
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
        async function saveVolunteer(e) {
            e.preventDefault();
            
            const id = document.getElementById('volunteer-id').value;
            const volunteer = {
                first_name: document.getElementById('first-name').value,
                last_name: document.getElementById('last-name').value,
                email: document.getElementById('email').value,
                mobile: document.getElementById('mobile').value,
                volunteer_area: document.getElementById('volunteer-area').value,
                address: document.getElementById('address').value
            };

            try {
                let response;
                if (id) {
                    // Update existing volunteer
                    response = await fetch(`/admin/volunteer/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(volunteer)
                    });
                } else {
                    // Create new volunteer
                    response = await fetch('/admin/volunteers', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(volunteer)
                    });
                }

                const result = await response.json();
                
                if (result.success) {
                    // Reload the page to get fresh data from database
                    window.location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Failed to save volunteer'));
                }
            } catch (error) {
                console.error('Error saving volunteer:', error);
                alert('Error: Failed to save volunteer. Please try again.');
            }
        }

        // View Volunteer
        function viewVolunteer(id) {
            const volunteer = volunteers.find(v => v.id === id);
            if (volunteer) {
                const content = document.getElementById('view-content');
                content.innerHTML = `
                    <div style="display: grid; gap: 1rem;">
                        <div><strong>Name:</strong> ${volunteer.first_name} ${volunteer.last_name}</div>
                        <div><strong>Email:</strong> ${volunteer.email}</div>
                        <div><strong>Mobile:</strong> ${volunteer.mobile || 'N/A'}</div>
                        <div><strong>Area:</strong> ${volunteer.volunteer_area ? volunteer.volunteer_area.charAt(0).toUpperCase() + volunteer.volunteer_area.slice(1) : 'N/A'}</div>
                        <div><strong>Address:</strong> ${volunteer.address || 'N/A'}</div>
                        <div><strong>Status:</strong> <span class="badge badge-success">Active</span></div>
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
        async function deleteVolunteer(id) {
            if (confirm('Are you sure you want to delete this volunteer?')) {
                try {
                    const response = await fetch(`/admin/volunteer/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    const result = await response.json();
                    
                    if (response.ok) {
                        // Reload the page to get fresh data from database
                        window.location.reload();
                    } else {
                        alert('Error: ' + (result.message || 'Failed to delete volunteer'));
                    }
                } catch (error) {
                    console.error('Error deleting volunteer:', error);
                    alert('Error: Failed to delete volunteer. Please try again.');
                }
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

        function showLogoutModal() {
            document.getElementById('logout-modal').style.display = 'flex';
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').style.display = 'none';
        }
        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }

        // Theme (dark / light) toggle -------------------------------------------------
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

        function showLogoutModal() {
            document.getElementById('logout-modal').style.display = 'flex';
        }
        function hideLogoutModal() {
            document.getElementById('logout-modal').style.display = 'none';
        }
        function confirmLogout() {
            document.getElementById('logout-form').submit();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Volunteers</title>
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

        .btn-danger {
            background-color: transparent;
            color: #ef4444;
            border: 1px solid #ef4444;
        }

        .btn-danger:hover {
            background-color: #ef4444;
            color: white;
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

        .action-links {
            display: flex;
            gap: 0.5rem;
        }

        .action-links a {
            color: #ff6b35;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .action-links a:hover {
            color: #ff8c5a;
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
            text-decoration: none;
            color: #ff6b35;
        }

        .pagination .active {
            background-color: #ff6b35;
            color: white;
        }

        .pagination a:hover {
            background-color: #2d3e52;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-users"></i>
                    Manage Volunteers
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
                <h2 class="card-title">All Volunteers</h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            @if ($volunteers->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Area</th>
                            <th>Education</th>
                            <th>Lifegroup</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($volunteers as $volunteer)
                            <tr>
                                <td>{{ $volunteer->first_name }} {{ $volunteer->last_name }}</td>
                                <td>{{ $volunteer->email }}</td>
                                <td>{{ $volunteer->mobile }}</td>
                                <td>{{ ucwords(str_replace('-', ' ', $volunteer->volunteer_area)) }}</td>
                                <td>{{ ucwords(str_replace('-', ' ', $volunteer->education)) }}</td>
                                <td>{{ ucfirst($volunteer->lifegroup) }}</td>
                                <td>
                                    <div class="action-links">
                                        <a href="{{ route('admin.volunteer.show', $volunteer->id) }}">View</a>
                                        <a href="#" onclick="deleteVolunteer({{ $volunteer->id }})">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $volunteers->links() }}
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 2rem;">No volunteers found.</p>
            @endif
        </div>
    </div>

    <script>
        function deleteVolunteer(id) {
            if (confirm('Are you sure you want to delete this volunteer?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/volunteer/${id}`;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>

# Backend Documentation

The VMS backend is built with **Laravel 12.0** running on PHP 8.2+. It follows the standard MVC (Model-View-Controller) architecture.

## Structure

- **`app/Models/`**: Eloquent ORM models representing database tables.
- **`app/Http/Controllers/`**: Contains the application logic, handling requests and returning views or JSON.
- **`routes/web.php`**: Defines all application routes, including API-like endpoints.
- **`database/migrations/`**: Defines the database schema changes.

## Key Modules

### 1. Authentication & Roles
- **Model**: `User`
- **Logic**: Uses Laravel's built-in authentication.
- **Roles**:
  - `admin`: Full access to dashboard, volunteer management, org chart, and settings.
  - `volunteer`: Limited access to their own dashboard (`VolunteerDashboardController`) to view profile and vote in polls.
- **Middleware**: Custom role-based middleware ensures users can only access appropriate routes.

### 2. Volunteer Management
- **Controller**: `VolunteerController` (Registration), `AdminDashboardController` (Management).
- **Functionality**:
  - **Registration**: Public-facing form for new volunteers.
  - **Management**: Admins can view, edit, and delete volunteer profiles.
  - **Dashboard**: `VolunteerDashboardController` renders the React-based profile page for volunteers.

### 3. Attendance Tracking
- **Controller**: `AttendancePerformanceController`, `AdminDashboardController`.
- **Model**: `Attendance`.
- **Logic**:
  - Admins record attendance manually.
  - Calculates attendance rates for statistics.
  - Supports statuses: `present`, `absent`, `excused`.

### 4. Performance Evaluation
- **Controller**: `AttendancePerformanceController`.
- **Model**: `PerformanceTracking`.
- **Logic**:
  - Admins rate volunteers on metrics like reliability and punctuality (0-100 scale).
  - Stores feedback and evaluator name.
  - Used to identify "Top Performers" on the dashboard.

### 5. Polling System
- **Controllers**: `PollController` (Voting), `PollManagementController` (Admin).
- **Models**: `Poll`, `PollOption`, `PollVote` (pivot).
- **Logic**:
  - Admins create polls with options and max vote limits.
  - Volunteers vote via the React dashboard.
  - Prevents duplicate voting per poll.

### 6. Organization Chart
- **Controller**: `OrgChartController`, `AdminDashboardController`.
- **Model**: `OrgChart`.
- **Logic**:
  - Stores the complex structure of the organization (Teams Alpha-Foxtrot, logistics, etc.) in a single record using JSON columns.
  - **JSON Columns**: `teams`, `kitchen_truck`, `vehicles`, etc. store nested data structures.
  - Frontend (`OrgChart` React component) renders this data visually.

### 7. Auto-Assignments
- **Controller**: `AssignmentController`.
- **Logic**:
  - Algorithms to automatically distribute volunteers into teams based on skills or random distribution (implementation details within the controller).

## Configuration

- **`.env`**: Stores environment variables (DB credentials, app key, debug mode).
- **`config/`**: Standard Laravel configuration files.

## Security

- **CSRF Protection**: Enabled for all POST/PUT/DELETE requests.
- **Authentication**: `auth` middleware protects sensitive routes.
- **Authorization**: Role checks prevent unauthorized access to admin features.

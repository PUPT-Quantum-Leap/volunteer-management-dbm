# Volunteer Management System (VMS)

## Project Overview

The Volunteer Management System (VMS) is a comprehensive Laravel-based web application designed to manage volunteers, track attendance, evaluate performance, conduct polls, and organize volunteer activities. The system provides both admin and volunteer-facing interfaces with role-based access controls.

### Architecture & Technologies

- **Backend Framework**: Laravel 12.0 (PHP 8.2+)
- **Frontend**: React 18.2 with Tailwind CSS 4.1
- **Build Tool**: Vite 7.0
- **Database**: MySQL
- **Icons**: FontAwesome and Lucide React
- **Development Tools**: Composer, NPM, PHPUnit

### Core Features

#### Authentication & Authorization
- User authentication with secure login/logout
- Role-based access control (admin/user)
- User registration via signup page

#### Volunteer Management
- Complete volunteer registration and profile management
- Detailed volunteer profiles with emergency contacts, skills, availability, etc.
- Self-registration via `/volunteer-form`

#### Attendance Tracking
- Recording and monitoring volunteer attendance
- Status tracking (present, absent, excused)
- Event-based attendance logging
- Detailed attendance statistics

#### Performance Evaluation
- Track volunteer performance metrics (reliability, punctuality, quality)
- Scoring system (0-100) with feedback
- Performance analytics and reports

#### Polling System
- Create and manage polls with voting capabilities
- Configurable vote limits per poll
- Real-time voting functionality

#### Organization Management
- Organization chart management
- Team assignments and leadership roles
- Auto-assignment system for volunteers

#### Dashboard Interfaces
- Admin dashboard with comprehensive metrics
- Volunteer dashboard with personal data
- Statistics and analytics views

## Database Schema

### Core Tables
- `users` - System users with authentication
- `volunteers` - Volunteer profile information (links to users optionally via user_id)
- `attendance` - Attendance records with status and event details
- `performance_tracking` - Performance evaluations with scoring
- `polls` - Poll questions and configurations
- `poll_options` - Poll answer options
- `poll_votes` - Individual vote records
- `org_chart` - Organizational structure information

### Key Relationships
- Volunteers can optionally belong to users
- Attendance records link to volunteers
- Performance tracking links to volunteers
- Poll options belong to polls
- Poll votes link to polls, options, and volunteers

## Building and Running

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL database
- Git

### Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd vms_db
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Environment setup:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure database:
   - Update `.env` file with database credentials
   - Create MySQL database

6. Run migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Build assets:
   ```bash
   npm run build
   ```

### Alternative Quick Setup
Use the provided setup script:
```bash
composer run setup
```

### Running the Application

#### Development Mode
```bash
composer run dev
```
This starts:
- Laravel development server
- Queue worker
- Log monitoring
- Vite development server with hot reload

#### Production Build
```bash
npm run build
php artisan serve
```

## Main Application Structure

### Routes (Web)
- `/` - Welcome page
- `/signup` - User registration
- `/login` - User login
- `/volunteer-form` - Volunteer registration
- `/volunteer/{id}/dashboard` - Volunteer dashboard
- `/admin/dashboard` - Admin dashboard
- `/polls/*` - Poll management
- `/org-chart` - Organization chart
- `/auto-assignments` - Automatic assignment system

### API Endpoints
- `POST /api/polls/{poll}/vote` - Submit a vote for a poll option
- `GET /api/volunteer/{id}/attendance-stats` - Get attendance statistics
- `GET /api/volunteer/{id}/performance-summary` - Get performance metrics
- `POST /api/assignments/generate` - Generate volunteer assignments
- `POST /api/assignments/save` - Save generated assignments

### Controllers
- `AdminDashboardController` - Admin dashboard and management features
- `VolunteerDashboardController` - Volunteer dashboard functionality
- `SignupController` - User registration
- `LoginController` - User authentication
- `VolunteerController` - Volunteer registration
- `PollController` - Poll voting functionality
- `PollManagementController` - Poll creation and management
- `AttendancePerformanceController` - Attendance and performance tracking
- `OrgChartController` - Organization chart management
- `AssignmentController` - Volunteer assignment system

## Development Guidelines

### Backend Standards
- Follow Laravel conventions (PascalCase classes, camelCase methods)
- Use RESTful naming conventions
- Implement proper middleware for authentication and authorization
- Thorough request validation
- Follow PSR-4 autoloading standards
- Use appropriate model relationships and casts

### Frontend Standards
- React functional components with hooks
- Consistent prop naming
- Proper error handling
- Tailwind CSS for styling
- Component-based architecture

### Security Practices
- CSRF protection on all forms
- Input validation and sanitization
- Role-based access control
- Proper database relationship constraints

### Code Quality
- Use Laravel Pint for code formatting
- Follow PSR-4 autoloading standards
- Consistent indentation and formatting
- Meaningful variable and function names
- Proper documentation of complex logic

## Available Commands

### Composer Scripts
- `composer run setup` - Full installation setup
- `composer run dev` - Development server with hot reload
- `composer run test` - Run test suite

### NPM Scripts
- `npm run build` - Build production assets
- `npm run dev` - Development server

### Laravel Artisan Commands
- `php artisan serve` - Start development server
- `php artisan migrate` - Run database migrations
- `php artisan db:seed` - Run database seeders
- `php artisan test` - Run tests
- `php artisan key:generate` - Generate application key

## Testing

Run the complete test suite:
```bash
composer run test
```

Run specific tests:
```bash
php artisan test --filter=TestClassName
```

## Common Tasks

### Managing Volunteers
- Admins can view, edit, and delete volunteers from `/admin/volunteers`
- Volunteers can register themselves via `/volunteer-form`
- Admins can view individual volunteer details and history

### Managing Attendance
- Admins can record attendance at `/admin/attendance`
- Attendance statistics are available in admin dashboard
- Each attendance record includes date, status, event name, and notes

### Managing Performance
- Admins can record performance evaluations at `/admin/performance`
- Multiple metrics (reliability, punctuality, quality) with scores
- Performance history and analytics available in admin dashboard

### Creating and Managing Polls
- Admins can create polls at `/polls/create`
- Volunteers can participate in active polls
- Vote counting and analytics available in admin interface

### Organization and Assignments
- Organization charts can be managed at `/org-chart`
- Auto-assignment system available at `/auto-assignments`
- Team structures and leadership roles can be configured

## Troubleshooting

### Common Installation Issues
- Ensure PHP 8.2+ is installed and in PATH
- Check that Composer and NPM are properly installed
- Verify database connection details in `.env` file
- Make sure all required PHP extensions are enabled

### Development Issues
- Clear configuration cache: `php artisan config:clear`
- Clear route cache: `php artisan route:clear`
- Clear view cache: `php artisan view:clear`
- Run `npm install` if React components aren't loading properly

### Database Issues
- Run `php artisan migrate:status` to check migration status
- Reset database if needed: `php artisan migrate:fresh --seed`
- Check database connection in `.env` file
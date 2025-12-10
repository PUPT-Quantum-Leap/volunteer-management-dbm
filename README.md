# Volunteer Management System

A comprehensive Laravel-based web application for managing volunteers, tracking attendance, evaluating performance, conducting polls, and organizing volunteer activities.

## Features

### Core Functionality
- **User Authentication**: Secure login/logout with role-based access (admin/user)
- **Volunteer Management**: Complete volunteer registration and profile management
- **Attendance Tracking**: Record and monitor volunteer attendance with detailed statistics
- **Performance Evaluation**: Track volunteer performance metrics (reliability, punctuality, quality)
- **Polling System**: Create and manage polls with voting capabilities and vote limits
- **Organization Chart**: Manage organizational structure and team assignments
- **Auto-Assignments**: Automated volunteer assignment system

### Admin Dashboard
- Comprehensive dashboard with key metrics and statistics
- Volunteer management (view, edit, delete)
- Attendance management and reporting
- Performance tracking and analytics
- Organization chart editor
- Poll creation and management

### Volunteer Features
- Self-registration with detailed profile information
- Personal dashboard with attendance and performance history
- Poll participation
- Profile management

## Technology Stack

- **Backend**: Laravel 12.0 (PHP 8.2+)
- **Frontend**: React 18.2, Tailwind CSS 4.1
- **Database**: MySQL
- **Build Tool**: Vite 7.0
- **Icons**: FontAwesome, Lucide React
- **Development Tools**: Composer, NPM, PHPUnit

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL database
- Git

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd volunteer-management-dbm
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - Create a MySQL database

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

### Quick Setup (Alternative)

Use the provided setup script:
```bash
composer run setup
```

This will install dependencies, copy environment file, generate app key, run migrations, install npm packages, and build assets.

## Running the Application

### Development Mode
```bash
composer run dev
```

This starts:
- Laravel development server
- Queue worker
- Log monitoring
- Vite development server with hot reload

### Production Build
```bash
npm run build
php artisan serve
```

## Usage

### User Registration and Login

1. **Admin Registration**: Create admin users through the signup page
2. **Volunteer Registration**: Volunteers can register through `/volunteer-form`
3. **Login**: Access the system through `/login`

### Admin Features

Access admin features at `/admin/dashboard` (requires admin role):

- **Dashboard**: View system statistics and recent activity
- **Volunteers**: Manage volunteer profiles and information
- **Attendance**: Record and view attendance records
- **Performance**: Evaluate and track volunteer performance
- **Org Chart**: Manage organizational structure

### Volunteer Features

- **Dashboard**: View personal attendance and performance data
- **Polls**: Participate in active polls
- **Profile**: Update personal information

## API Endpoints

### Polls
- `POST /api/polls/{poll}/vote` - Submit a vote for a poll option

### Attendance & Performance
- `GET /api/volunteer/{id}/attendance-stats` - Get attendance statistics
- `GET /api/volunteer/{id}/performance-summary` - Get performance metrics

### Assignments
- `POST /api/assignments/generate` - Generate volunteer assignments
- `POST /api/assignments/save` - Save generated assignments

## Database Schema

### Core Tables
- `users` - System users with authentication
- `volunteers` - Volunteer profile information
- `attendance` - Attendance records
- `performance_tracking` - Performance evaluations
- `polls` - Poll questions
- `poll_options` - Poll answer options
- `poll_votes` - Vote records
- `org_chart` - Organizational structure

### Key Relationships
- Volunteers belong to users (optional)
- Attendance records link to volunteers
- Performance tracking links to volunteers
- Poll options belong to polls
- Poll votes link to polls, options, and volunteers

## Testing

Run the test suite:
```bash
composer run test
```

Run specific tests:
```bash
php artisan test --filter=TestClassName
```

## Code Quality

### Linting
```bash
./vendor/bin/pint
```

### Code Style
- Follows PSR-4 autoloading
- Laravel conventions (PascalCase classes, camelCase methods)
- Consistent indentation and formatting

## Development Guidelines

### Controllers
- Use RESTful naming conventions
- Implement proper middleware usage
- Validate requests thoroughly

### Models
- Define `$fillable` arrays for mass assignment
- Use appropriate casts and relationships
- Follow Laravel naming conventions

### Views
- Use Blade templating syntax
- Maintain consistent indentation
- Escape output for security

### React Components
- Functional components with hooks
- Consistent prop naming
- Proper error handling

### Security
- CSRF protection on all forms
- Input validation and sanitization
- Role-based access control

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and linting
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support or questions, please create an issue in the repository.
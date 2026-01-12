# Volunteer Management System

**Comprehensive Laravel-based web application for managing volunteers, tracking attendance, evaluating performance, conducting polls, and organizing volunteer activities.**

---

## 📖 About

The **Volunteer Management System (VMS)** is a modern web application built with Laravel 12 and React to streamline volunteer coordination for organizations. It provides comprehensive tools for volunteer registration, attendance tracking, performance evaluation, and organizational planning.

### 🎯 Problem Statement

Organizations and coordinators often struggle with:

- ❌ Disorganized volunteer records and scattered information
- ❌ Manual tracking of volunteer attendance and hours
- ❌ No systematic way to evaluate volunteer performance
- ❌ Difficulty coordinating large-scale volunteer activities
- ❌ Lack of transparency in team assignments and organizational structure

### ✨ Our Solution

The Volunteer Management System provides an intuitive, efficient platform to:

- ✅ Centralize volunteer information and profiles
- ✅ Automate attendance tracking with detailed statistics
- ✅ Evaluate volunteer performance with measurable metrics
- ✅ Create polls for democratic decision-making
- ✅ Manage organizational charts and team assignments
- ✅ Auto-assign volunteers based on skills and requirements

---

## 🚀 Key Features

<table>
<tr>
<td width="50%">

### 👥 Volunteer Management

- Complete volunteer registration with detailed profiles
- Skills, training, and availability tracking
- Emergency contact information
- Lifegroup membership status
- Profile updates and deletion

### 📊 Attendance Tracking

- Record attendance by date and event
- Status options: present, absent, excused
- Real-time statistics calculation
- Attendance rate percentages
- Historical attendance records

### 📈 Performance Evaluation

- Metrics: reliability, punctuality, quality (0-100 scale)
- Detailed feedback text and evaluator name
- Historical performance data
- Top performer identification
- Performance trends over time

</td>
<td width="50%">

### 🗳️ Polling System

- Create polls with multiple options
- Vote tracking with configurable limits
- Prevention of duplicate votes
- Real-time vote count updates
- Admin poll management

### 🏗️ Organization Chart

- Leadership structure management
- Team assignments by area (Alpha, Bravo, Charlie, Delta, Echo, Foxtrot)
- Role assignments (Planning, Purchasing, Safety, etc.)
- Meal breakdown and vehicle assignments
- Mobile kitchen operations support

### ⚡ Auto-Assignments

- Skill-based volunteer assignment algorithm
- Role requirements based on meal objectives
- Coordinator and team member assignment
- Automated distribution optimization
- Fair workload distribution

</td>
</tr>
</table>

---

## 🛠️ Tech Stack

### Backend

![PHP](https://img.shields.io/badge/PHP_8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

- **Framework:** Laravel 12.0
- **Language:** PHP 8.2+
- **Database:** MySQL
- **ORM:** Eloquent
- **Authentication:** Laravel Auth (database sessions)
- **Session Driver:** Database
- **Queue Driver:** Database
- **Cache Driver:** Database

### Frontend

![React](https://img.shields.io/badge/React_18.2-61DAFB?style=for-the-badge&logo=react&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS_4-38B2AC?style=for-the-badge&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite_7.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

- **Framework:** React 18.2.0
- **Styling:** Tailwind CSS 4.1.17
- **Build Tool:** Vite 7.0.7
- **Icons:** Lucide React, FontAwesome
- **HTTP Client:** Axios
- **Components:** Functional components with hooks

### Development & Testing

![PHPUnit](https://img.shields.io/badge/PHPUnit-EF2D5E?style=for-the-badge&logo=php&logoColor=white)
![Laravel Pint](https://img.shields.io/badge/Laravel_Pint-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
![NPM](https://img.shields.io/badge/NPM-CB3837?style=for-the-badge&logo=npm&logoColor=white)

- **Testing:** PHPUnit
- **Code Formatting:** Laravel Pint
- **Dependency Management:** Composer, NPM
- **Development Server:** Laravel Artisan Serve
- **Hot Reload:** Vite HMR

---

## 📦 Project Structure

```
volunteer-management-dbm/
├── vms_db/                          # Main Laravel application
│   ├── app/
│   │   ├── Http/
│   │   │   └── Controllers/         # RESTful controllers
│   │   │       ├── AdminDashboardController.php
│   │   │       ├── AssignmentController.php
│   │   │       ├── LoginController.php
│   │   │       ├── OrgChartController.php
│   │   │       ├── PollController.php
│   │   │       ├── PollManagementController.php
│   │   │       ├── SignupController.php
│   │   │       └── VolunteerDashboardController.php
│   │   └── Models/                  # Eloquent models
│   │       ├── Attendance.php
│   │       ├── OrgChart.php
│   │       ├── PerformanceTracking.php
│   │       ├── Poll.php
│   │       ├── PollOption.php
│   │       ├── PollVote.php
│   │       ├── User.php
│   │       └── Volunteer.php
│   ├── database/
│   │   └── migrations/              # Database schema
│   │       ├── 2024_01_01_000001_create_users_table.php
│   │       ├── 2024_01_01_000002_create_volunteers_table.php
│   │       ├── 2024_01_01_000003_create_attendance_table.php
│   │       ├── 2024_01_01_000004_create_performance_tracking_table.php
│   │       ├── 2024_01_01_000005_create_polls_table.php
│   │       ├── 2024_01_01_000006_create_poll_options_table.php
│   │       ├── 2024_01_01_000007_create_poll_votes_table.php
│   │       └── 2024_01_01_000008_create_org_chart_table.php
│   ├── resources/
│   │   ├── views/                   # Blade templates
│   │   │   ├── admin/
│   │   │   │   ├── dashboard.blade.php
│   │   │   │   ├── volunteers.blade.php
│   │   │   │   ├── attendance.blade.php
│   │   │   │   ├── performance.blade.php
│   │   │   │   └── org-chart-editor.blade.php
│   │   │   ├── volunteer-dashboard-new.blade.php
│   │   │   ├── poll-create.blade.php
│   │   │   ├── auto-assignments.blade.php
│   │   │   └── org-chart.blade.php
│   │   └── js/                      # React components
│   │       ├── org-chart.jsx
│   │       └── volunteer-dashboard.jsx
│   ├── routes/
│   │   └── web.php                  # Application routes
│   ├── config/                      # Configuration files
│   ├── public/                      # Web root
│   └── tests/                       # Unit and feature tests
├── composer.json                    # PHP dependencies
├── package.json                     # NPM dependencies
├── .env                             # Environment configuration
└── README.md                        # This file
```

---

## 🔐 Security & Access Control

- **🔐 Role-Based Access Control:** Admin and user roles with proper middleware
- **🛡️ CSRF Protection:** All forms protected with CSRF tokens
- **✅ Input Validation:** Thorough validation on all requests
- **🔑 Secure Authentication:** Database session-based auth
- **📝 Audit Trail:** Track changes through user actions

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL database
- Git

### Installation

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

---

## 📡 API Endpoints

### Authentication
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Login form |
| POST | `/login` | Process login |
| POST | `/logout` | Logout |
| GET | `/signup` | Signup form |
| POST | `/signup` | Process signup |

### Admin Routes (prefix `/admin`, middleware `auth`)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/dashboard` | Admin dashboard |
| GET | `/admin/volunteers` | List volunteers |
| GET | `/admin/volunteer/{id}` | View volunteer details |
| PUT | `/admin/volunteer/{id}` | Update volunteer |
| DELETE | `/admin/volunteer/{id}` | Delete volunteer |
| GET | `/admin/attendance` | Manage attendance |
| POST | `/admin/attendance/record` | Record attendance |
| GET | `/admin/performance` | Manage performance |
| POST | `/admin/performance/record` | Record performance |
| GET | `/admin/org-chart` | Edit org chart |
| POST | `/admin/org-chart` | Update org chart |

### Volunteer Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/volunteer/{id}/dashboard` | Volunteer dashboard |
| PUT | `/volunteer/{id}/update` | Update profile |
| DELETE | `/volunteer/{id}/delete` | Delete profile |

### Polls API
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/polls/create` | Create poll form |
| POST | `/polls/create` | Store poll |
| GET | `/polls/manage` | Manage polls |
| POST | `/api/polls/{poll}/vote` | Vote on poll |
| DELETE | `/polls/{poll}/delete` | Delete poll |

### Assignments API
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/auto-assignments` | Auto-assign page |
| POST | `/api/assignments/generate` | Generate assignments |
| POST | `/api/assignments/save` | Save assignments |

### Organization Chart
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/org-chart` | View org chart |

---

## 📊 Database Schema

### Core Tables

| Table | Description |
|-------|-------------|
| `users` | System users with role field (admin/user) |
| `volunteers` | Volunteer profiles with personal/contact info |
| `attendance` | Attendance records (volunteer_id FK, date, status, event) |
| `performance_tracking` | Performance evaluations (volunteer_id FK, metrics, scores) |
| `polls` | Poll questions |
| `poll_options` | Poll options with vote counts (poll_id FK) |
| `poll_votes` | Vote records to prevent duplicates (unique poll_id+volunteer_id) |
| `org_chart` | Organization chart with JSON team/vehicle data |

### Key Relationships

```
User → hasMany Volunteers (via user_id)
Volunteer → hasMany Attendance
Volunteer → hasMany PerformanceTracking
Poll → hasMany PollOptions
Poll → hasMany PollVotes
PollOption → belongsTo Poll
PollVote → belongsTo Poll
Attendance → belongsTo Volunteer
PerformanceTracking → belongsTo Volunteer
```

---

## 🧪 Testing & Quality

### Running Tests
```bash
composer run test
```

Run specific tests:
```bash
php artisan test --filter=TestClassName
```

### Code Quality

#### Linting
```bash
./vendor/bin/pint
```

#### Code Style Standards
- **PSR-4 Autoloading:** Follows PHP-FIG standards
- **Laravel Conventions:** PascalCase classes, camelCase methods
- **Consistent Formatting:** Laravel Pint for code formatting
- **Naming Conventions:** snake_case for tables and columns

---

## 📝 Development Guidelines

### Controllers
- ✅ Use RESTful naming conventions
- ✅ Implement proper middleware usage
- ✅ Validate requests thoroughly
- ✅ Return JSON responses for APIs

### Models
- ✅ Define `$fillable` arrays for mass assignment
- ✅ Use appropriate casts and relationships
- ✅ Follow Laravel naming conventions
- ✅ Add type hints for PHP 8.2+ features

### Views
- ✅ Use Blade templating syntax
- ✅ Maintain consistent indentation
- ✅ Escape output for security
- ✅ Use React components for dynamic features

### React Components
- ✅ Functional components with hooks
- ✅ Consistent prop naming
- ✅ Proper error handling
- ✅ Clean component structure

### Database
- ✅ Use migrations for schema changes
- ✅ Add foreign key constraints
- ✅ Use seeders for test data
- ✅ Proper indexing for performance

---

## 👥 User Roles

### 👤 Admin
- Complete system access
- Volunteer management (view, edit, delete)
- Attendance management and reporting
- Performance tracking and analytics
- Organization chart editing
- Poll creation and management
- Auto-assignment configuration

### 🙋 Volunteer
- Self-registration
- Personal dashboard with attendance history
- Poll participation
- Profile management
- View organizational chart

---

## 🔧 Configuration

### Environment Variables

Key configuration in `.env`:
```env
APP_NAME="Volunteer Management System"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vms_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_DRIVER=database
```

### Build Scripts (composer.json)

```json
"scripts": {
    "setup": "composer install + npm install + build assets + migrate DB",
    "dev": "Run Laravel server, queue worker, and Vite concurrently",
    "test": "Run PHPUnit tests"
}
```

---

## 🤝 Contributing

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. **Make your changes**
4. **Run tests and linting**
   ```bash
   composer run test
   ./vendor/bin/pint
   ```
5. **Submit a pull request**

---

## 📜 License

This project is licensed under the MIT License.

---

## 📞 Support

For support or questions, please create an issue in the repository.

---

<div align="center">

**Built with ❤️ using Laravel 12, React, and Tailwind CSS**

[⬆ Back to Top](#volunteer-management-system)

</div>

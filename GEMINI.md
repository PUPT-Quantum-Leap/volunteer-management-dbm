# Volunteer Management System

## Project Overview
A comprehensive web application for managing volunteers, tracking attendance, performance, and organizational structure. Built with **Laravel 12.0** (backend) and **React 18** (frontend), styled with **Tailwind CSS 4**.

**Key Features:**
*   **Role-based Access:** Admin and Volunteer dashboards.
*   **Volunteer Management:** Registration, profiles, and auto-assignments.
*   **Tracking:** Attendance and performance metrics.
*   **Interactive Tools:** Polling system and Organization Chart editor.

## Project Structure
The core application resides in the `vms_db/` directory.

*   `vms_db/app/`: Core PHP logic (Controllers, Models).
*   `vms_db/resources/js/`: React components (`org-chart.jsx`, `volunteer-dashboard.jsx`).
*   `vms_db/resources/views/`: Blade templates (entry points for React apps).
*   `vms_db/routes/`: Route definitions (`web.php`).
*   `vms_db/database/`: Migrations and Seeders.

## Building and Running

**Note:** Execute these commands from the `vms_db/` directory.

### Initial Setup
The project includes a helper script to set up everything (dependencies, env, key, migrations, build):
```bash
composer run setup
```

### Development Server
Starts Laravel server, Queue worker, and Vite hot-reload server concurrently:
```bash
composer run dev
```

### Production Build
1.  Build frontend assets:
    ```bash
    npm run build
    ```
2.  Serve the application:
    ```bash
    php artisan serve
    ```

### Testing
Run the PHPUnit test suite:
```bash
composer run test
```

## Development Conventions

*   **Framework:** Follows standard Laravel architecture (MVC).
*   **Frontend:** React components are embedded in Blade views. Use `npm run dev` for hot module replacement.
*   **Styling:** Utility-first CSS with Tailwind.
*   **Code Quality:**
    *   **Linting:** `vendor/bin/pint` (Laravel Pint).
    *   **Formatting:** PSR-12 (PHP), Prettier (JS/React).
*   **Database:** Default configuration uses SQLite (`database/database.sqlite`), but supports MySQL (configurable in `.env`).

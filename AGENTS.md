# AGENTS.md - Volunteer Management System

## Build/Lint/Test Commands
- **Setup project**: `composer run setup` (installs deps, sets up env, migrates DB, builds assets)
- **Development server**: `composer run dev` (runs Laravel server, queue worker, logs, and Vite dev server concurrently)
- **Build assets**: `npm run build` (Vite production build)
- **Run all tests**: `composer run test` or `php artisan test`
- **Run single test**: `php artisan test --filter=TestClassName` or `phpunit --filter=TestClassName`
- **Lint PHP**: `./vendor/bin/pint` (Laravel Pint code formatter)
- **Type check**: No dedicated type checker; use PHPStan if installed

## Code Style Guidelines
- **PHP**: Follow PSR-4 autoloading, Laravel conventions (PascalCase classes, camelCase methods, snake_case DB columns)
- **Models**: Use `$fillable`, `$casts`, relationships; add type hints for PHP 8.2+ features
- **Controllers**: RESTful naming, proper middleware usage, validate requests
- **Error handling**: Use try-catch in async operations, return JSON errors with user-friendly messages
- **Imports**: Group use statements alphabetically, separate framework vs. app imports
- **Blade templates**: Standard Laravel syntax, consistent indentation, escape output
- **React/JSX**: Functional components with hooks, consistent prop naming, handle errors gracefully
- **Database**: Use migrations for schema changes, seeders for test data, foreign key constraints
- **Security**: Always use CSRF protection, validate/sanitize input, avoid raw queries
- **Commits**: Use conventional commits (feat:, fix:, refactor:), keep changes focused
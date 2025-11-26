# Technology Stack - Ujikom Mading Friska

## Programming Languages & Versions
- **PHP**: ^8.2 (Primary backend language)
- **JavaScript**: ES6+ (Frontend interactivity)
- **HTML/CSS**: Modern web standards
- **SQL**: Database queries and migrations

## Framework & Core Dependencies
- **Laravel Framework**: ^11.0 (PHP web framework)
- **Laravel Tinker**: ^2.9 (REPL for Laravel)
- **Blade**: Template engine (included with Laravel)

## Frontend Build System
- **Vite**: ^5.0 (Modern build tool and dev server)
- **Laravel Vite Plugin**: ^1.0 (Laravel integration)
- **Axios**: ^1.6.4 (HTTP client for API requests)

## Development Dependencies
- **PHPUnit**: ^10.5 (Testing framework)
- **Laravel Pint**: ^1.13 (Code style fixer)
- **Laravel Sail**: ^1.26 (Docker development environment)
- **Faker**: ^1.23 (Test data generation)
- **Mockery**: ^1.6 (Mocking framework)
- **Collision**: ^8.0 (Error reporting)
- **Spatie Laravel Ignition**: ^2.4 (Error page enhancement)

## Database
- **SQLite**: Default database (database.sqlite)
- **Eloquent ORM**: Database abstraction layer
- **Migration System**: Version-controlled schema management

## Asset Management
- **Bootstrap**: CSS framework (via CDN/assets)
- **Bootstrap Icons**: Icon library
- **Custom SCSS**: Compiled stylesheets
- **Vendor Assets**: Third-party libraries in public/assets/vendor/

## Development Commands

### Laravel Artisan
```bash
php artisan serve          # Start development server
php artisan migrate        # Run database migrations
php artisan db:seed        # Populate database with seeders
php artisan tinker         # Interactive REPL
php artisan key:generate   # Generate application key
```

### Frontend Build
```bash
npm run dev               # Start Vite development server
npm run build            # Build for production
```

### Code Quality
```bash
./vendor/bin/pint        # Fix code style
./vendor/bin/phpunit     # Run tests
```

## Environment Configuration
- **.env**: Environment-specific settings
- **SQLite Database**: File-based database for development
- **Session-based Authentication**: No external auth providers
- **File Storage**: Local filesystem for uploads

## Browser Compatibility
- Modern browsers supporting ES6+
- Responsive design for mobile/tablet/desktop
- Bootstrap-based responsive grid system
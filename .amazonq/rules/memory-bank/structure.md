# Project Structure - Ujikom Mading Friska

## Directory Organization

### Core Application (`app/`)
- **Http/Controllers/**: Request handling and business logic
- **Models/**: Eloquent models (Artikel, Kategori, Like, User)
- **Providers/**: Service providers for dependency injection

### Database Layer (`database/`)
- **migrations/**: Database schema definitions
  - User management tables
  - Article and category structures
  - Like system and activity logging
- **seeders/**: Default data population
- **factories/**: Test data generation

### Frontend Resources (`resources/`)
- **views/**: Blade templates organized by user roles
  - `admin/`: Administrative interfaces
  - `auth/`: Authentication pages
  - `guru/`: Teacher-specific views
  - `siswa/`: Student interfaces
  - `public/`: Public-facing pages
  - `layouts/`: Shared layout templates
  - `partials/`: Reusable components
- **css/**: Stylesheets
- **js/**: JavaScript assets

### Public Assets (`public/`)
- **assets/**: Frontend resources (CSS, JS, images)
- **forms/**: Contact and form handling
- Static files and entry point

### Configuration (`config/`)
- Database, authentication, and application settings
- Service configurations for Laravel components

### Routes (`routes/`)
- **web.php**: Web application routing
- **console.php**: Artisan command definitions

## Core Components & Relationships

### Data Models
- **User**: Multi-role user system (admin, guru, siswa)
- **Artikel**: Article content with author relationships
- **Kategori**: Article categorization system
- **Like**: User interaction tracking

### Authentication Flow
- Role-based access control
- Session management
- Protected routes by user type

### Content Management Flow
- Article creation → Category assignment → Publication → User interaction
- Activity logging for audit trails
- Permission-based content access

## Architectural Patterns

### MVC Architecture
- Models handle data logic and relationships
- Views provide role-specific interfaces
- Controllers manage request/response flow

### Role-Based Design
- Separate view directories for each user type
- Permission-based feature access
- Hierarchical user management

### Template Inheritance
- Base layouts with role-specific extensions
- Reusable partial components
- Consistent UI patterns across roles
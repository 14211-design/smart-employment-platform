# Smart Employment Platform

A comprehensive Laravel 10 application that connects job seekers with employers, featuring skill tests, career roadmaps, and intelligent job matching.

## Features

### For Job Seekers
- **Job Search & Application**: Browse and apply for jobs with advanced filtering
- **Skill Tests**: Take skill assessments to prove your expertise
- **Career Roadmaps**: Follow structured learning paths for career development
- **Profile Management**: Maintain your professional profile with resume uploads
- **Application Tracking**: Monitor the status of all your job applications

### For Employers
- **Job Posting**: Create and manage job listings
- **Application Management**: Review and manage job applications
- **Company Profile**: Showcase your company to potential candidates

### For Administrators
- **User Management**: Manage platform users
- **Content Management**: Create and manage skill tests and career roadmaps
- **Analytics Dashboard**: Monitor platform statistics

## Tech Stack

- **Framework**: Laravel 10
- **Database**: SQLite (default), MySQL/PostgreSQL supported
- **Frontend**: Blade Templates with Bootstrap 5
- **Authentication**: Laravel built-in authentication

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- SQLite or MySQL/PostgreSQL

### Setup Steps

1. **Clone the repository**
```bash
git clone https://github.com/14211-design/smart-employment-platform.git
cd smart-employment-platform
```

2. **Install dependencies**
```bash
composer install
```

3. **Set up environment**
```bash
cp .env.example .env
# Edit .env if needed
```

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Create database**
```bash
touch database/database.sqlite
```

6. **Run migrations**
```bash
php artisan migrate
```

7. **Create storage symlink**
```bash
php artisan storage:link
```

8. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## Database Structure

### Tables
- **users**: User accounts (job seekers, employers, admins)
- **employers**: Employer/company profiles
- **jobs**: Job listings
- **job_applications**: Job applications submitted by users
- **skill_tests**: Skill assessment tests
- **user_skill_tests**: User skill test attempts and results
- **roadmaps**: Career development roadmaps

## Configuration

### Employment Platform Configuration
Edit `config/employment.php` to customize:
- User roles and permissions
- Job and application statuses
- Skill test difficulty levels
- Pagination settings
- Feature flags

### File Upload Configuration
Edit `config/upload.php` to customize:
- Maximum file sizes
- Allowed file types
- Storage paths
- Image dimensions

## User Roles

1. **Job Seeker** (default)
   - Browse and apply for jobs
   - Take skill tests
   - Access career roadmaps

2. **Employer**
   - Post and manage jobs
   - Review applications
   - Manage company profile

3. **Admin**
   - Full platform access
   - Create skill tests and roadmaps
   - Manage users and content

## Routes

### Public Routes
- `/` - Home page
- `/jobs` - Browse jobs
- `/skill-tests` - View skill tests
- `/career-roadmaps` - View career roadmaps

### Authenticated Routes
- `/dashboard` - User dashboard
- `/profile` - User profile
- `/my-applications` - User's job applications

### Employer Routes (require employer role)
- `/employer/jobs/create` - Create job posting
- `/employer/jobs/{job}/edit` - Edit job posting

### Admin Routes (require admin role)
- `/admin/dashboard` - Admin dashboard
- `/admin/users` - Manage users
- `/admin/skill-tests` - Manage skill tests
- `/admin/roadmaps` - Manage roadmaps

## Models & Relationships

### User Model
- Has one Employer profile
- Has many JobApplications
- Belongs to many SkillTests (pivot: user_skill_tests)

### Employer Model
- Belongs to User
- Has many Jobs

### Job Model
- Belongs to Employer
- Has many JobApplications

### JobApplication Model
- Belongs to Job
- Belongs to User

### SkillTest Model
- Belongs to many Users (pivot: user_skill_tests)

### Roadmap Model
- Standalone model for career guidance

## Development

### Running Tests
```bash
php artisan test
# or
./vendor/bin/phpunit
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Seeding
Create seeders in `database/seeders/` and run:
```bash
php artisan db:seed
```

## Deployment

### Production Checklist
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Generate a strong `APP_KEY`
4. Configure production database
5. Run migrations: `php artisan migrate --force`
6. Optimize: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
7. Set proper file permissions on storage and bootstrap/cache

## License

MIT License

## Support

For issues and questions, please open an issue on GitHub.
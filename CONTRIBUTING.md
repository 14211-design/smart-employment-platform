# Contributing to Smart Employment Platform

Thank you for your interest in contributing to the Smart Employment Platform! This document provides guidelines for contributing to the project.

## Development Setup

1. Fork the repository
2. Clone your fork: `git clone https://github.com/your-username/smart-employment-platform.git`
3. Install dependencies: `composer install`
4. Copy `.env.example` to `.env` and configure your environment
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. (Optional) Seed database: `php artisan db:seed`

## Making Changes

1. Create a new branch: `git checkout -b feature/your-feature-name`
2. Make your changes
3. Write or update tests as needed
4. Run tests: `php artisan test`
5. Commit your changes with clear commit messages
6. Push to your fork: `git push origin feature/your-feature-name`
7. Open a Pull Request

## Code Style

- Follow PSR-12 coding standards
- Use Laravel best practices
- Write descriptive variable and function names
- Comment complex logic
- Run `./vendor/bin/pint` for code formatting

## Testing

- Write tests for new features
- Ensure all tests pass before submitting PR
- Maintain or improve code coverage

## Pull Request Guidelines

- Provide a clear description of the changes
- Reference any related issues
- Include screenshots for UI changes
- Ensure CI/CD checks pass
- Request review from maintainers

## Reporting Issues

When reporting issues, please include:
- Clear description of the problem
- Steps to reproduce
- Expected vs actual behavior
- Environment details (OS, PHP version, etc.)
- Error messages or logs

## Feature Requests

We welcome feature requests! Please:
- Check if the feature already exists or has been requested
- Provide clear use cases
- Explain the benefit to users
- Be open to discussion

## Code of Conduct

- Be respectful and inclusive
- Provide constructive feedback
- Help others learn and grow
- Follow project guidelines

Thank you for contributing!

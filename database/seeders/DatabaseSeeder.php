<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create employer user
        $employer = \App\Models\User::create([
            'name' => 'Tech Company',
            'email' => 'employer@example.com',
            'password' => bcrypt('password'),
            'role' => 'employer',
            'email_verified_at' => now(),
        ]);

        // Create employer profile
        $employerProfile = \App\Models\Employer::create([
            'user_id' => $employer->id,
            'company_name' => 'Tech Innovations Inc.',
            'company_description' => 'Leading technology company specializing in software development and cloud solutions.',
            'company_website' => 'https://techinnovations.example.com',
            'industry' => 'Technology',
            'company_size' => '50-200',
            'location' => 'San Francisco, CA',
        ]);

        // Create sample jobs
        \App\Models\Job::create([
            'employer_id' => $employerProfile->id,
            'title' => 'Senior Software Engineer',
            'description' => 'We are looking for an experienced software engineer to join our team. You will work on cutting-edge projects using modern technologies.',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field. 5+ years of experience in software development. Strong knowledge of PHP, Laravel, and modern web technologies.',
            'location' => 'San Francisco, CA (Hybrid)',
            'job_type' => 'full-time',
            'experience_level' => 'senior',
            'salary_min' => 120000,
            'salary_max' => 180000,
            'skills_required' => ['PHP', 'Laravel', 'Vue.js', 'MySQL', 'Docker'],
            'status' => 'published',
            'published_at' => now(),
            'expires_at' => now()->addDays(30),
        ]);

        \App\Models\Job::create([
            'employer_id' => $employerProfile->id,
            'title' => 'Frontend Developer',
            'description' => 'Join our frontend team to build beautiful and responsive user interfaces.',
            'requirements' => 'Experience with React or Vue.js. Strong CSS and JavaScript skills. Portfolio of previous work.',
            'location' => 'Remote',
            'job_type' => 'remote',
            'experience_level' => 'mid',
            'salary_min' => 80000,
            'salary_max' => 120000,
            'skills_required' => ['JavaScript', 'React', 'CSS', 'HTML5'],
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create job seeker user
        $jobSeeker = \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'jobseeker@example.com',
            'password' => bcrypt('password'),
            'role' => 'job_seeker',
            'email_verified_at' => now(),
            'bio' => 'Passionate software developer with 3 years of experience.',
            'skills' => ['PHP', 'Laravel', 'JavaScript', 'MySQL'],
            'location' => 'San Francisco, CA',
        ]);

        // Create skill tests
        \App\Models\SkillTest::create([
            'title' => 'PHP Fundamentals',
            'description' => 'Test your knowledge of PHP basics, syntax, and common patterns.',
            'skill_category' => 'Programming',
            'difficulty' => 'beginner',
            'duration_minutes' => 30,
            'questions' => [
                [
                    'question' => 'What does PHP stand for?',
                    'options' => ['Personal Home Page', 'PHP: Hypertext Preprocessor', 'Private Host Protocol', 'Pre Hypertext Processor'],
                    'correct_answer' => 1
                ],
                [
                    'question' => 'Which symbol is used to start a variable in PHP?',
                    'options' => ['@', '#', '$', '%'],
                    'correct_answer' => 2
                ],
            ],
            'passing_score' => 70,
            'is_active' => true,
        ]);

        \App\Models\SkillTest::create([
            'title' => 'Laravel Framework',
            'description' => 'Advanced Laravel framework concepts including Eloquent, routing, and middleware.',
            'skill_category' => 'Framework',
            'difficulty' => 'intermediate',
            'duration_minutes' => 45,
            'questions' => [
                [
                    'question' => 'What is Eloquent in Laravel?',
                    'options' => ['A database driver', 'An ORM (Object-Relational Mapping)', 'A template engine', 'A testing framework'],
                    'correct_answer' => 1
                ],
            ],
            'passing_score' => 75,
            'is_active' => true,
        ]);

        // Create career roadmaps
        \App\Models\Roadmap::create([
            'title' => 'Full Stack Web Developer',
            'description' => 'Complete roadmap to becoming a full stack web developer from beginner to advanced.',
            'career_path' => 'web-development',
            'level' => 'beginner',
            'milestones' => [
                ['title' => 'Learn HTML & CSS', 'duration' => '2 weeks'],
                ['title' => 'JavaScript Fundamentals', 'duration' => '4 weeks'],
                ['title' => 'Learn a Frontend Framework (React/Vue)', 'duration' => '6 weeks'],
                ['title' => 'Backend Development with PHP/Laravel', 'duration' => '8 weeks'],
                ['title' => 'Database Design & SQL', 'duration' => '4 weeks'],
                ['title' => 'Build Portfolio Projects', 'duration' => '8 weeks'],
            ],
            'resources' => [
                ['type' => 'course', 'title' => 'HTML & CSS Complete Guide', 'url' => 'https://example.com'],
                ['type' => 'book', 'title' => 'JavaScript: The Good Parts', 'url' => 'https://example.com'],
            ],
            'estimated_duration_weeks' => 32,
            'is_published' => true,
        ]);

        \App\Models\Roadmap::create([
            'title' => 'Data Analyst Career Path',
            'description' => 'Learn data analysis, visualization, and statistical methods.',
            'career_path' => 'data-science',
            'level' => 'beginner',
            'milestones' => [
                ['title' => 'Statistics Fundamentals', 'duration' => '4 weeks'],
                ['title' => 'SQL & Database Queries', 'duration' => '4 weeks'],
                ['title' => 'Python for Data Analysis', 'duration' => '6 weeks'],
                ['title' => 'Data Visualization Tools', 'duration' => '4 weeks'],
                ['title' => 'Business Intelligence Tools', 'duration' => '4 weeks'],
            ],
            'resources' => [
                ['type' => 'course', 'title' => 'Data Analysis with Python', 'url' => 'https://example.com'],
            ],
            'estimated_duration_weeks' => 22,
            'is_published' => true,
        ]);
    }
}

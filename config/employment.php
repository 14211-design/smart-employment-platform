<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Employment Platform Configuration
    |--------------------------------------------------------------------------
    */

    'user_roles' => [
        'job_seeker' => 'job_seeker',
        'employer' => 'employer',
        'admin' => 'admin',
    ],

    'job_status' => [
        'draft' => 'draft',
        'published' => 'published',
        'closed' => 'closed',
        'filled' => 'filled',
    ],

    'application_status' => [
        'pending' => 'pending',
        'reviewing' => 'reviewing',
        'interviewed' => 'interviewed',
        'accepted' => 'accepted',
        'rejected' => 'rejected',
    ],

    'skill_test_difficulty' => [
        'beginner' => 'beginner',
        'intermediate' => 'intermediate',
        'advanced' => 'advanced',
        'expert' => 'expert',
    ],

    'skill_test_status' => [
        'not_started' => 'not_started',
        'in_progress' => 'in_progress',
        'completed' => 'completed',
    ],

    'pagination' => [
        'jobs_per_page' => 15,
        'applications_per_page' => 10,
        'tests_per_page' => 10,
    ],

    'features' => [
        'enable_skill_tests' => true,
        'enable_career_roadmaps' => true,
        'enable_ai_matching' => false,
        'require_email_verification' => true,
    ],
];

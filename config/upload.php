<?php

return [
    /*
    |--------------------------------------------------------------------------
    | File Upload Configuration
    |--------------------------------------------------------------------------
    */

    'max_file_size' => env('MAX_UPLOAD_SIZE', 5120), // in KB (5MB default)

    'allowed_resume_types' => [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ],

    'allowed_resume_extensions' => [
        'pdf',
        'doc',
        'docx',
    ],

    'allowed_image_types' => [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ],

    'allowed_image_extensions' => [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp',
    ],

    'resume_storage_path' => 'resumes',
    'avatar_storage_path' => 'avatars',
    'company_logo_storage_path' => 'company_logos',

    'image_max_dimensions' => [
        'avatar' => [
            'width' => 500,
            'height' => 500,
        ],
        'company_logo' => [
            'width' => 1000,
            'height' => 1000,
        ],
    ],
];

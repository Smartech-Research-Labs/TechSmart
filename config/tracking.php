<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tracking & Analytics Configuration
    |--------------------------------------------------------------------------
    |
    | Configure all your tracking and analytics integrations here.
    |
    */

    'google_analytics' => [
        'enabled' => env('GOOGLE_ANALYTICS_ENABLED', true),
        'measurement_id' => env('GOOGLE_ANALYTICS_MEASUREMENT_ID'),
        'property_id' => env('GOOGLE_ANALYTICS_PROPERTY_ID'),
        'credentials_path' => storage_path('app/google-analytics-credentials.json'),
    ],

    'google_tag_manager' => [
        'enabled' => env('GOOGLE_TAG_MANAGER_ENABLED', true),
        'container_id' => env('GOOGLE_TAG_MANAGER_ID'),
    ],

    'facebook_pixel' => [
        'enabled' => env('FACEBOOK_PIXEL_ENABLED', true),
        'pixel_id' => env('FACEBOOK_PIXEL_ID'),
    ],

    'microsoft_clarity' => [
        'enabled' => env('MICROSOFT_CLARITY_ENABLED', true),
        'project_id' => env('MICROSOFT_CLARITY_ID'),
    ],

    'google_search_console' => [
        'enabled' => env('GOOGLE_SEARCH_CONSOLE_ENABLED', true),
        'site_url' => env('APP_URL', 'https://omniviatech.com'),
        'credentials_path' => storage_path('app/google-search-console-credentials.json'),
    ],

    'hotjar' => [
        'enabled' => env('HOTJAR_ENABLED', false),
        'site_id' => env('HOTJAR_SITE_ID'),
    ],

    'data_layer' => [
        'enabled' => true,
        'events' => [
            'page_view' => true,
            'scroll_depth' => true,
            'video_play' => true,
            'form_submission' => true,
            'button_click' => true,
        ],
    ],
];

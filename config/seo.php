<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel SEO Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file contains all the settings for the Laravel SEO
    | package. Configure these settings to match your preferences.
    |
    */

    'defaults' => [
        'title' => env('APP_NAME', 'OmniviaTech'),
        'description' => 'Transform your business with cutting-edge digital solutions',
        'keywords' => 'web development, digital marketing, software development',
        'image' => '/storage/og-image-default.jpg',
        'robots' => 'index, follow',
        'charset' => 'utf-8',
        'viewport' => 'width=device-width, initial-scale=1',
    ],

    'twitter' => [
        'card' => env('TWITTER_CARD_TYPE', 'summary_large_image'),
        'site' => env('TWITTER_HANDLE', '@omniviatech'),
        'creator' => env('TWITTER_CREATOR', '@omniviatech'),
    ],

    'open_graph' => [
        'locale' => 'en_US',
        'type' => 'website',
    ],

    'schema' => [
        'type' => env('SCHEMA_ORG_TYPE', 'Organization'),
        'name' => env('APP_NAME', 'OmniviaTech'),
        'url' => env('APP_URL', 'https://omniviatech.com'),
        'email' => env('CONTACT_EMAIL', 'info@omniviatech.com'),
        'phone' => env('CONTACT_PHONE', '+254710351517'),
        'logo' => '/storage/logo.png',
    ],

    'tracking' => [
        'google_analytics' => env('GOOGLE_ANALYTICS_ID'),
        'google_tag_manager' => env('GOOGLE_TAG_MANAGER_ID'),
        'facebook_pixel' => env('FACEBOOK_PIXEL_ID'),
        'microsoft_clarity' => env('MICROSOFT_CLARITY_ID'),
    ],

    'search_console' => [
        'verification_code' => env('GOOGLE_SEARCH_CONSOLE_CODE'),
        'credentials_path' => storage_path('app/google-credentials.json'),
    ],

    'analytics' => [
        'credentials_path' => storage_path('app/google-analytics-credentials.json'),
        'property_id' => env('GOOGLE_ANALYTICS_PROPERTY_ID'),
    ],

    'cache' => [
        'duration' => 3600, // 1 hour
        'enabled' => env('SEO_CACHE_ENABLED', true),
    ],
];

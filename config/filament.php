<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Admin Panel Configuration
    |--------------------------------------------------------------------------
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'assets_path' => null,

    'cache_panel_authorization' => false,

    'relative_database_path' => true,

    'middleware' => [
        'web' => [
            \App\Http\Middleware\SeoManagementAccess::class,
        ],
    ],

    'panels' => [
        'admin' => [
            'path' => 'admin',
            'auth_guard' => 'web',
            'timezone' => 'UTC',
            'vite_theme' => 'resources/css/app.css',
        ],
    ],

    'livewire_loading_delay' => 'default',

    'filament_loading_delay' => 'default',

];

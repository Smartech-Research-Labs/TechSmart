<?php

use Illuminate\Support\Facades\Route;

// SPA catch-all route - serve Vue app for all non-API routes
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


<?php

use Illuminate\Support\Facades\Route;

// Renamed blog posts: 301 old URLs to the new slug (once the post carries the new slug)
Route::get('/blog/{slug}', function (string $slug) {
    $new = config('redirects.blog_slugs')[$slug] ?? null;
    if ($new && \App\Models\Blog::where('slug', $new)->exists()) {
        return redirect('/blog/' . $new, 301);
    }

    return view('app');
});

// SPA catch-all route - serve Vue app for all non-API routes
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


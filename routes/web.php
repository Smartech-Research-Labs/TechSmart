<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// Renamed blog posts: 301 old URLs to the new slug (once the post carries the new slug)
Route::get('/blog/{slug}', function (string $slug) {
    $new = config('redirects.blog_slugs')[$slug] ?? null;
    if ($new && \App\Models\Blog::where('slug', $new)->exists()) {
        return redirect('/blog/' . $new, 301);
    }

    return view('app');
});

// Serve uploaded files when the public/storage link is missing on the server.
// If the link exists, the web server returns the file directly and this never runs.
Route::get('/storage/{path}', function (string $path) {
    $disk = Storage::disk('public');
    abort_if(preg_match('#(^|/)\.#', $path) || !$disk->fileExists($path), 404);

    return $disk->response($path, null, [
        'Cache-Control' => 'public, max-age=604800',
        'X-Content-Type-Options' => 'nosniff',
    ]);
})->where('path', '.*')->withoutMiddleware('web');

// SPA catch-all route - serve Vue app for all non-API routes
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


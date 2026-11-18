<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * List published blog posts with pagination.
     */
    public function index(Request $request)
    {
        $query = Blog::published()->with('author:id,name,avatar');

        if ($category = $request->query('category')) {
            $query->byCategory($category);
        }

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $blogs = $query->paginate(12);

        return response()->json($blogs);
    }

    /**
     * Show a single blog post by slug.
     */
    public function show(string $slug)
    {
        // Accept a renamed post's old or new slug (see config/redirects.php)
        $renamed = config('redirects.blog_slugs', []);
        $slugs = array_values(array_filter([$slug, $renamed[$slug] ?? null, array_search($slug, $renamed, true) ?: null]));

        $blog = Blog::published()
            ->whereIn('slug', $slugs)
            ->with('author:id,name,avatar')
            ->firstOrFail();

        // Increment views
        $blog->increment('views');

        // Get related posts
        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->take(3)
            ->get();

        // Sidebar data
        // reorder(): published() sorts by published_at, which MySQL rejects with DISTINCT
        // (error 3065) — that made every blog post page and the category list fail.
        $categories = Blog::published()
            ->reorder()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        $recentBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->take(5)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at']);

        $mostViewed = Blog::published()
            ->where('id', '!=', $blog->id)
            ->reorder('views', 'desc') // published() already sorts by date; views must come first
            ->take(5)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at', 'views']);

        $previous = Blog::published()
            ->where('published_at', '<', $blog->published_at)
            ->first(['title', 'slug']);

        $next = Blog::published()
            ->where('published_at', '>', $blog->published_at)
            ->reorder('published_at', 'asc')
            ->first(['title', 'slug']);

        return response()->json([
            'blog' => $blog,
            'related' => $related,
            'categories' => $categories,
            'recent' => $recentBlogs,
            'most_viewed' => $mostViewed,
            'previous' => $previous,
            'next' => $next,
        ]);
    }

    /**
     * Get all blog categories.
     */
    public function categories()
    {
        // reorder(): published() sorts by published_at, which MySQL rejects with DISTINCT
        // (error 3065) — that made every blog post page and the category list fail.
        $categories = Blog::published()
            ->reorder()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        return response()->json(['categories' => $categories]);
    }
}

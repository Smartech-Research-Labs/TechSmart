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
        $blog = Blog::published()
            ->where('slug', $slug)
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
        $categories = Blog::published()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        $recentBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->take(5)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at']);

        $mostViewed = Blog::published()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('views')
            ->take(5)
            ->get(['id', 'title', 'slug', 'featured_image', 'published_at', 'views']);

        return response()->json([
            'blog' => $blog,
            'related' => $related,
            'categories' => $categories,
            'recent' => $recentBlogs,
            'most_viewed' => $mostViewed,
        ]);
    }

    /**
     * Get all blog categories.
     */
    public function categories()
    {
        $categories = Blog::published()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return response()->json(['categories' => $categories]);
    }
}

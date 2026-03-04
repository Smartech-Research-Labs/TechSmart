<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('author:id,name')
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json($blogs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = $request->user()->id;

        if ($request->boolean('is_published') && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        return response()->json([
            'message' => 'Blog post created successfully',
            'blog' => $blog->load('author:id,name'),
        ], 201);
    }

    public function show(Blog $blog)
    {
        return response()->json([
            'blog' => $blog->load('author:id,name'),
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
            'is_published' => 'boolean',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->boolean('is_published') && ! $blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return response()->json([
            'message' => 'Blog post updated successfully',
            'blog' => $blog->fresh()->load('author:id,name'),
        ]);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->json([
            'message' => 'Blog post deleted successfully',
        ]);
    }
}

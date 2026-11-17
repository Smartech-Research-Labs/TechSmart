<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_published', true)->with('media');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $products = $query->orderBy('order')->paginate(12);

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_published', true)
            ->with(['media', 'reviews' => function ($query) {
                $query->approved()->with('user')->latest()->take(10);
            }])
            ->firstOrFail()
            ->append('image_url');

        // Get related products (same category, exclude current)
        $related = Product::where('is_published', true)
            ->where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get()
            ->append('image_url');

        // Case studies are linked to services (service_id / service_ids), not products —
        // the case_studies table has no product columns, and querying them made every
        // product page fail with a 500 ("Product Not Found" on the frontend).
        $caseStudies = [];

        // Get related blog posts (matching product category or name)
        $relatedBlogs = Blog::published()
            ->where(function ($q) use ($product) {
                $q->where('category', $product->category)
                  ->orWhere('title', 'LIKE', '%' . $product->name . '%');
            })
            ->with('author')
            ->take(3)
            ->get();

        return response()->json([
            'product' => $product,
            'related' => $related,
            'case_studies' => $caseStudies,
            'related_blogs' => $relatedBlogs,
        ]);
    }

    public function categories()
    {
        $categories = Product::where('is_published', true)
            ->select('category')
            ->distinct()
            ->pluck('category');

        return response()->json($categories);
    }
}

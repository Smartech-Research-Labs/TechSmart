<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            ->firstOrFail();

        return response()->json($product);
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

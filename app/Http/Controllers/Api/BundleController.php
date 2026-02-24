<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::where('is_published', true)
            ->with(['items.bundleable', 'media'])
            ->orderBy('order')
            ->get();

        return response()->json($bundles);
    }

    public function show($slug)
    {
        $bundle = Bundle::where('slug', $slug)
            ->where('is_published', true)
            ->with(['items.bundleable', 'media'])
            ->firstOrFail();

        return response()->json($bundle);
    }
}

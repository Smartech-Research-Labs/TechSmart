<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::with('items.bundleable')->orderBy('order')->get();

        return response()->json($bundles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_label' => 'nullable|string|max:100',
            'whats_included' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $bundle = Bundle::create($validated);

        return response()->json([
            'message' => 'Bundle created',
            'bundle' => $bundle,
        ], 201);
    }

    public function update(Request $request, Bundle $bundle)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_label' => 'nullable|string|max:100',
            'whats_included' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $bundle->update($validated);

        return response()->json([
            'message' => 'Bundle updated',
            'bundle' => $bundle,
        ]);
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->items()->delete();
        $bundle->delete();

        return response()->json(['message' => 'Bundle deleted']);
    }
}

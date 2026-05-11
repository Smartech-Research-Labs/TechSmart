<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    /**
     * Public: Get all published packages
     */
    public function index()
    {
        $packages = Package::published()
            ->orderBy('order')
            ->get();

        return response()->json($packages);
    }

    /**
     * Public: Get single package by slug
     */
    public function show($slug)
    {
        $package = Package::where('slug', $slug)
            ->published()
            ->with('packageFeatures')
            ->firstOrFail();

        return response()->json($package);
    }

    /**
     * Admin: List all packages (including unpublished)
     */
    public function adminIndex()
    {
        $this->authorize('view', Package::class);

        $packages = Package::with('packageFeatures')
            ->orderBy('order')
            ->paginate(15);

        return response()->json($packages);
    }

    /**
     * Admin: Create new package
     */
    public function store(Request $request)
    {
        $this->authorize('create', Package::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:packages,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'tier_level' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'price_label' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'highlight_text' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'includes' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $package = Package::create($validated);

        return response()->json($package, 201);
    }

    /**
     * Admin: Update package
     */
    public function update(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:packages,slug,' . $package->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'tier_level' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'price_label' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'highlight_text' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'includes' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $package->update($validated);

        return response()->json($package);
    }

    /**
     * Admin: Delete package
     */
    public function destroy(Package $package)
    {
        $this->authorize('delete', $package);

        $package->delete();

        return response()->json(null, 204);
    }

    /**
     * Admin: Restore deleted package
     */
    public function restore($id)
    {
        $this->authorize('restore', Package::class);

        $package = Package::withTrashed()->findOrFail($id);
        $package->restore();

        return response()->json($package);
    }

    /**
     * Admin: Add feature to package
     */
    public function addFeature(Request $request, Package $package)
    {
        $this->authorize('update', $package);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_highlighted' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $feature = $package->packageFeatures()->create($validated);

        return response()->json($feature, 201);
    }

    /**
     * Admin: Update package feature
     */
    public function updateFeature(Request $request, Package $package, PackageFeature $feature)
    {
        $this->authorize('update', $package);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_highlighted' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $feature->update($validated);

        return response()->json($feature);
    }

    /**
     * Admin: Delete feature
     */
    public function deleteFeature(Package $package, PackageFeature $feature)
    {
        $this->authorize('update', $package);

        $feature->delete();

        return response()->json(null, 204);
    }
}

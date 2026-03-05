<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Industry::query()->orderBy('sort_order')->orderBy('title');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn ($q) => $q->where('title', 'like', "%{$s}%")
                ->orWhere('short_description', 'like', "%{$s}%"));
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $industries = $query->paginate($request->input('per_page', 20));

        return response()->json($industries);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'nullable|string|max:255|unique:industries,slug',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'icon'              => 'nullable|string|max:100',
            'image'             => 'nullable|string|max:500',
            'banner_image'      => 'nullable|string|max:500',
            'sub_sectors'       => 'nullable|array',
            'process_steps'     => 'nullable|array',
            'features'          => 'nullable|array',
            'stats'             => 'nullable|array',
            'cta_title'         => 'nullable|string|max:255',
            'cta_description'   => 'nullable|string|max:500',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'sort_order'        => 'nullable|integer',
            'is_active'         => 'boolean',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $industry = Industry::create($data);

        return response()->json(['industry' => $industry], 201);
    }

    public function show(Industry $industry): JsonResponse
    {
        return response()->json(['industry' => $industry]);
    }

    public function update(Request $request, Industry $industry): JsonResponse
    {
        $data = $request->validate([
            'title'             => 'sometimes|required|string|max:255',
            'slug'              => "nullable|string|max:255|unique:industries,slug,{$industry->id}",
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'icon'              => 'nullable|string|max:100',
            'image'             => 'nullable|string|max:500',
            'banner_image'      => 'nullable|string|max:500',
            'sub_sectors'       => 'nullable|array',
            'process_steps'     => 'nullable|array',
            'features'          => 'nullable|array',
            'stats'             => 'nullable|array',
            'cta_title'         => 'nullable|string|max:255',
            'cta_description'   => 'nullable|string|max:500',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'sort_order'        => 'nullable|integer',
            'is_active'         => 'boolean',
        ]);

        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $industry->update($data);

        return response()->json(['industry' => $industry->fresh()]);
    }

    public function destroy(Industry $industry): JsonResponse
    {
        $industry->delete();

        return response()->json(['message' => 'Industry deleted successfully.']);
    }
}

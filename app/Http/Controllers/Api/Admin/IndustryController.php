<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\MediaLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndustryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Industry::query()
            ->with(['media' => function ($q) {
                $q->orderBy('industry_media.created_at');
            }])
            ->orderBy('sort_order')
            ->orderBy('title');

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
            'image_id'          => 'nullable|exists:media_library,id',
            'banner_image_id'   => 'nullable|exists:media_library,id',
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

        // Extract media IDs for later association
        $imageId = $data['image_id'] ?? null;
        $bannerImageId = $data['banner_image_id'] ?? null;
        unset($data['image_id'], $data['banner_image_id']);

        $industry = Industry::create($data);

        // Associate media if provided
        if ($imageId) {
            $industry->media()->attach($imageId, ['type' => 'image']);
        }
        if ($bannerImageId) {
            $industry->media()->attach($bannerImageId, ['type' => 'banner']);
        }

        $industry->load('media');

        return response()->json(['industry' => $industry], 201);
    }

    public function show(Industry $industry): JsonResponse
    {
        $industry->load('media');
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
            'image_id'          => 'nullable|exists:media_library,id',
            'banner_image_id'   => 'nullable|exists:media_library,id',
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

        // Extract media IDs for later association
        $imageId = $data['image_id'] ?? null;
        $bannerImageId = $data['banner_image_id'] ?? null;
        unset($data['image_id'], $data['banner_image_id']);

        $industry->update($data);

        // Update media associations if provided
        if ($imageId !== null) {
            $industry->media()->wherePivot('type', 'image')->detach();
            if ($imageId) {
                $industry->media()->attach($imageId, ['type' => 'image']);
            }
        }
        if ($bannerImageId !== null) {
            $industry->media()->wherePivot('type', 'banner')->detach();
            if ($bannerImageId) {
                $industry->media()->attach($bannerImageId, ['type' => 'banner']);
            }
        }

        $industry->load('media');

        return response()->json(['industry' => $industry->fresh()]);
    }

    public function destroy(Industry $industry): JsonResponse
    {
        $industry->delete();

        return response()->json(['message' => 'Industry deleted successfully.']);
    }
}

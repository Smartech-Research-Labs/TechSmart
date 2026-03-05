<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_published', true)
            ->orderBy('order')
            ->get()
            ->append('image_url');

        // Group by category_group for frontend to render categorised sections
        $grouped = $services->groupBy('category_group')->map(function ($items, $group) {
            return [
                'name' => $group ?: 'Other',
                'services' => $items->values(),
            ];
        })->values();

        return response()->json([
            'services' => $services,
            'grouped' => $grouped,
            'categories' => $services->pluck('category')->unique()->values(),
            'category_groups' => $services->pluck('category_group')->unique()->filter()->values(),
        ]);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_published', true)
            ->with(['reviews' => function ($query) {
                $query->approved()->with('user')->latest()->take(10);
            }])
            ->firstOrFail()
            ->append('image_url');

        // Get related services (same category group, exclude current)
        $related = Service::where('is_published', true)
            ->where('category_group', $service->category_group)
            ->where('id', '!=', $service->id)
            ->take(6)
            ->get()
            ->append('image_url');

        // Get case studies linked to this service (if CaseStudy model exists)
        $caseStudies = [];
        if (class_exists(\App\Models\CaseStudy::class)) {
            $caseStudies = \App\Models\CaseStudy::where('is_published', true)
                ->where(function ($q) use ($service) {
                    $q->where('service_id', $service->id)
                      ->orWhereJsonContains('service_ids', $service->id);
                })
                ->latest()
                ->take(3)
                ->get();
        }

        // Get related blog posts (matching service category or name in tags)
        $relatedBlogs = Blog::published()
            ->where(function ($q) use ($service) {
                $q->where('category', $service->category)
                  ->orWhere('category', $service->category_group)
                  ->orWhere('title', 'LIKE', '%' . $service->name . '%');
            })
            ->with('author')
            ->take(3)
            ->get();

        return response()->json([
            'service' => $service,
            'related' => $related,
            'case_studies' => $caseStudies,
            'related_blogs' => $relatedBlogs,
        ]);
    }

    public function byCategory($category)
    {
        $services = Service::where('category', $category)
            ->where('is_published', true)
            ->orderBy('order')
            ->get()
            ->append('image_url');

        return response()->json(['services' => $services]);
    }
}

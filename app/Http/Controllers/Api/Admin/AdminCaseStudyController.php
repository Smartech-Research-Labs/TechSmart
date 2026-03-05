<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudy::with('service:id,name,slug')
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('client_name', 'LIKE', "%{$search}%")
                  ->orWhere('industry', 'LIKE', "%{$search}%");
            });
        }

        return response()->json($query->paginate(15));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:2048',
            'client_name' => 'nullable|string|max:255',
            'client_logo' => 'nullable|string|max:2048',
            'industry' => 'nullable|string|max:100',
            'service_id' => 'nullable|exists:services,id',
            'service_ids' => 'nullable|array',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'metrics' => 'nullable|array',
            'technologies' => 'nullable|array',
            'testimonial_quote' => 'nullable|string|max:1000',
            'testimonial_author' => 'nullable|string|max:255',
            'testimonial_role' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->boolean('is_published') && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $caseStudy = CaseStudy::create($validated);

        return response()->json([
            'message' => 'Case study created successfully',
            'case_study' => $caseStudy->load('service:id,name,slug'),
        ], 201);
    }

    public function show(CaseStudy $caseStudy)
    {
        return response()->json([
            'case_study' => $caseStudy->load('service:id,name,slug'),
        ]);
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:2048',
            'client_name' => 'nullable|string|max:255',
            'client_logo' => 'nullable|string|max:2048',
            'industry' => 'nullable|string|max:100',
            'service_id' => 'nullable|exists:services,id',
            'service_ids' => 'nullable|array',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'results' => 'nullable|string',
            'metrics' => 'nullable|array',
            'technologies' => 'nullable|array',
            'testimonial_quote' => 'nullable|string|max:1000',
            'testimonial_author' => 'nullable|string|max:255',
            'testimonial_role' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($request->boolean('is_published') && ! $caseStudy->published_at) {
            $validated['published_at'] = now();
        }

        $caseStudy->update($validated);

        return response()->json([
            'message' => 'Case study updated successfully',
            'case_study' => $caseStudy->fresh()->load('service:id,name,slug'),
        ]);
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $caseStudy->delete();

        return response()->json([
            'message' => 'Case study deleted successfully',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index(Request $request)
    {
        $query = CaseStudy::published()->with('service:id,name,slug');

        // Filter by industry
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where(function ($q) use ($request) {
                $q->where('service_id', $request->service_id)
                  ->orWhereJsonContains('service_ids', (int) $request->service_id);
            });
        }

        $caseStudies = $query->paginate(12);

        // Get unique industries and services for filters
        $industries = CaseStudy::where('is_published', true)
            ->whereNotNull('industry')
            ->distinct()
            ->pluck('industry')
            ->values();

        return response()->json([
            'case_studies' => $caseStudies,
            'industries' => $industries,
        ]);
    }

    public function show($slug)
    {
        $caseStudy = CaseStudy::where('slug', $slug)
            ->where('is_published', true)
            ->with('service:id,name,slug')
            ->firstOrFail();

        // Get related case studies (same industry or service)
        $related = CaseStudy::where('is_published', true)
            ->where('id', '!=', $caseStudy->id)
            ->where(function ($q) use ($caseStudy) {
                if ($caseStudy->industry) {
                    $q->where('industry', $caseStudy->industry);
                }
                if ($caseStudy->service_id) {
                    $q->orWhere('service_id', $caseStudy->service_id);
                }
            })
            ->take(3)
            ->get();

        return response()->json([
            'case_study' => $caseStudy,
            'related' => $related,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\JsonResponse;

class IndustryController extends Controller
{
    /**
     * List all active industries (for listing page).
     */
    public function index(): JsonResponse
    {
        $industries = Industry::active()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get([
                'id', 'title', 'slug', 'short_description',
                'icon', 'image', 'stats', 'sort_order',
            ]);

        return response()->json(['industries' => $industries]);
    }

    /**
     * Show a single industry by slug (detail page).
     */
    public function show(Industry $industry): JsonResponse
    {
        if (!$industry->is_active) {
            abort(404);
        }

        return response()->json(['industry' => $industry]);
    }
}

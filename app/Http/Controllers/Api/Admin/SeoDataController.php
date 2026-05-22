<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\SeoData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoDataController
{
    /**
     * Get all SEO data.
     */
    public function index()
    {
        return response()->json(SeoData::paginate(15));
    }

    /**
     * Store a new SEO data record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|unique:seo_data,page_name',
            'route_name' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|string',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image,app,player',
            'twitter_title' => 'nullable|string',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|string',
            'schema_markup' => 'nullable|string',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        $seoData = SeoData::create($validated);

        return response()->json([
            'message' => 'SEO data created successfully',
            'data' => $seoData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Get a specific SEO data record.
     */
    public function show(SeoData $seoData)
    {
        return response()->json($seoData);
    }

    /**
     * Update a SEO data record.
     */
    public function update(Request $request, SeoData $seoData)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|unique:seo_data,page_name,' . $seoData->id,
            'route_name' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_title' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|string',
            'twitter_card' => 'nullable|string|in:summary,summary_large_image,app,player',
            'twitter_title' => 'nullable|string',
            'twitter_description' => 'nullable|string',
            'twitter_image' => 'nullable|string',
            'schema_markup' => 'nullable|string',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        $seoData->update($validated);

        return response()->json([
            'message' => 'SEO data updated successfully',
            'data' => $seoData,
        ]);
    }

    /**
     * Delete a SEO data record.
     */
    public function destroy(SeoData $seoData)
    {
        $seoData->delete();

        return response()->json([
            'message' => 'SEO data deleted successfully',
        ]);
    }

    /**
     * Get SEO data by page name.
     */
    public function getByPageName($pageName)
    {
        $seoData = SeoData::where('page_name', $pageName)->first();

        if (!$seoData) {
            return response()->json([
                'message' => 'SEO data not found',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($seoData);
    }

    /**
     * Bulk update SEO data.
     */
    public function bulkUpdate(Request $request)
    {
        $records = $request->validate([
            'records' => 'required|array',
            'records.*.id' => 'required|exists:seo_data,id',
            'records.*.meta_title' => 'nullable|string|max:60',
            'records.*.meta_description' => 'nullable|string|max:160',
            'records.*.meta_keywords' => 'nullable|string',
            'records.*.index' => 'boolean',
            'records.*.follow' => 'boolean',
        ]);

        foreach ($records['records'] as $record) {
            SeoData::find($record['id'])->update($record);
        }

        return response()->json([
            'message' => 'SEO data updated successfully',
        ]);
    }
}

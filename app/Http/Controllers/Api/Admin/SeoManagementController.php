<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\SeoData;
use App\Services\SeoService;
use App\Services\TrackingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SeoManagementController
{
    protected $trackingService;
    protected $seoService;

    public function __construct()
    {
        $this->trackingService = new TrackingService();
        $this->seoService = new SeoService();
    }

    /**
     * Get all SEO data with pagination.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search', '');

        $query = SeoData::query();

        if ($search) {
            $query->where('page_name', 'like', "%{$search}%")
                  ->orWhere('meta_title', 'like', "%{$search}%")
                  ->orWhere('meta_description', 'like', "%{$search}%");
        }

        $seoData = $query->paginate($perPage);

        return response()->json([
            'data' => $seoData->items(),
            'pagination' => [
                'total' => $seoData->total(),
                'per_page' => $seoData->perPage(),
                'current_page' => $seoData->currentPage(),
                'last_page' => $seoData->lastPage(),
            ]
        ]);
    }

    /**
     * Create new SEO entry.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|unique:seo_data,page_name',
            'route_name' => 'nullable|string',
            'page_type' => 'required|in:page,service,product,blog,custom',
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'og_title' => 'nullable|string|max:100',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'twitter_card' => 'nullable|in:summary,summary_large_image,app,player',
            'twitter_title' => 'nullable|string|max:70',
            'twitter_description' => 'nullable|string|max:200',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'canonical_url' => 'nullable|url',
            'schema_type' => 'nullable|in:Article,Product,Service,Organization,LocalBusiness,BreadcrumbList,FAQPage',
            'schema_markup' => 'nullable|json',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $validator->validated();

        // Handle image uploads
        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = $request->file('meta_image')->store('seo-images', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo-images', 'public');
        }
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('seo-images', 'public');
        }

        $seoData = SeoData::create($data);

        // Submit to Google Search Console if published
        if ($request->get('submit_to_search_console')) {
            $this->trackingService->submitUrlToSearchConsole($data['canonical_url']);
        }

        // Clear cache
        Cache::forget('seo_data_all');

        return response()->json([
            'message' => 'SEO data created successfully',
            'data' => $seoData,
        ], Response::HTTP_CREATED);
    }

    /**
     * Get specific SEO entry.
     */
    public function show(SeoData $seoData)
    {
        return response()->json($seoData);
    }

    /**
     * Update SEO entry.
     */
    public function update(Request $request, SeoData $seoData)
    {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|unique:seo_data,page_name,' . $seoData->id,
            'route_name' => 'nullable|string',
            'page_type' => 'required|in:page,service,product,blog,custom',
            'meta_title' => 'required|string|max:60',
            'meta_description' => 'required|string|max:160',
            'meta_keywords' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'og_title' => 'nullable|string|max:100',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'twitter_card' => 'nullable|in:summary,summary_large_image,app,player',
            'twitter_title' => 'nullable|string|max:70',
            'twitter_description' => 'nullable|string|max:200',
            'twitter_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'canonical_url' => 'nullable|url',
            'schema_type' => 'nullable|in:Article,Product,Service,Organization,LocalBusiness,BreadcrumbList,FAQPage',
            'schema_markup' => 'nullable|json',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $validator->validated();

        // Handle image uploads
        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = $request->file('meta_image')->store('seo-images', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo-images', 'public');
        }
        if ($request->hasFile('twitter_image')) {
            $data['twitter_image'] = $request->file('twitter_image')->store('seo-images', 'public');
        }

        $seoData->update($data);

        // Clear cache
        Cache::forget('seo_data_all');

        return response()->json([
            'message' => 'SEO data updated successfully',
            'data' => $seoData,
        ]);
    }

    /**
     * Delete SEO entry.
     */
    public function destroy(SeoData $seoData)
    {
        $seoData->delete();

        Cache::forget('seo_data_all');

        return response()->json([
            'message' => 'SEO data deleted successfully',
        ]);
    }

    /**
     * Get SEO preview for a page.
     */
    public function preview(Request $request)
    {
        $pageName = $request->get('page_name');
        $seoData = SeoData::where('page_name', $pageName)->first();

        if (!$seoData) {
            return response()->json(['error' => 'SEO data not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'page_preview' => [
                'google_search' => [
                    'title' => $seoData->meta_title,
                    'description' => $seoData->meta_description,
                    'url' => $seoData->canonical_url,
                ],
                'facebook' => [
                    'title' => $seoData->og_title ?? $seoData->meta_title,
                    'description' => $seoData->og_description ?? $seoData->meta_description,
                    'image' => $seoData->og_image,
                ],
                'twitter' => [
                    'card' => $seoData->twitter_card,
                    'title' => $seoData->twitter_title ?? $seoData->meta_title,
                    'description' => $seoData->twitter_description ?? $seoData->meta_description,
                    'image' => $seoData->twitter_image,
                ],
            ],
        ]);
    }

    /**
     * Get tracking configuration.
     */
    public function trackingConfig()
    {
        return response()->json([
            'google_analytics' => [
                'enabled' => config('tracking.google_analytics.enabled'),
                'measurement_id' => config('tracking.google_analytics.measurement_id') ? '***' : null,
            ],
            'google_tag_manager' => [
                'enabled' => config('tracking.google_tag_manager.enabled'),
                'container_id' => config('tracking.google_tag_manager.container_id') ? '***' : null,
            ],
            'facebook_pixel' => [
                'enabled' => config('tracking.facebook_pixel.enabled'),
                'pixel_id' => config('tracking.facebook_pixel.pixel_id') ? '***' : null,
            ],
            'microsoft_clarity' => [
                'enabled' => config('tracking.microsoft_clarity.enabled'),
                'project_id' => config('tracking.microsoft_clarity.project_id') ? '***' : null,
            ],
        ]);
    }

    /**
     * Get Google Analytics data.
     */
    public function analyticsData(Request $request)
    {
        $startDate = $request->get('start_date', '30daysAgo');
        $endDate = $request->get('end_date', 'today');

        $data = $this->trackingService->getGoogleAnalyticsData($startDate, $endDate);

        return response()->json($data);
    }

    /**
     * Submit URL to Google Search Console.
     */
    public function submitToSearchConsole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $result = $this->trackingService->submitUrlToSearchConsole($request->get('url'));

        return response()->json($result);
    }

    /**
     * Bulk update SEO data.
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'records' => 'required|array',
            'records.*.id' => 'required|exists:seo_data,id',
            'records.*.meta_title' => 'nullable|string|max:60',
            'records.*.meta_description' => 'nullable|string|max:160',
            'records.*.meta_keywords' => 'nullable|string',
            'records.*.index' => 'boolean',
            'records.*.follow' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        foreach ($request->get('records') as $record) {
            SeoData::find($record['id'])->update($record);
        }

        Cache::forget('seo_data_all');

        return response()->json([
            'message' => 'SEO data updated successfully',
        ]);
    }

    /**
     * Get SEO report/audit.
     */
    public function getAudit()
    {
        $seoDataCount = SeoData::count();
        $publishedPages = SeoData::where('index', true)->count();
        $missingDescriptions = SeoData::whereNull('meta_description')->orWhere('meta_description', '')->count();
        $missingKeywords = SeoData::whereNull('meta_keywords')->orWhere('meta_keywords', '')->count();
        $missingImages = SeoData::whereNull('og_image')->orWhere('og_image', '')->count();
        $tooLongTitles = SeoData::whereRaw('LENGTH(meta_title) > 60')->count();
        $tooLongDescriptions = SeoData::whereRaw('LENGTH(meta_description) > 160')->count();

        return response()->json([
            'total_pages' => $seoDataCount,
            'published_pages' => $publishedPages,
            'unpublished_pages' => $seoDataCount - $publishedPages,
            'issues' => [
                'missing_descriptions' => [
                    'count' => $missingDescriptions,
                    'severity' => 'high',
                    'message' => 'Pages without meta descriptions',
                ],
                'missing_keywords' => [
                    'count' => $missingKeywords,
                    'severity' => 'medium',
                    'message' => 'Pages without keywords',
                ],
                'missing_images' => [
                    'count' => $missingImages,
                    'severity' => 'medium',
                    'message' => 'Pages without OG images',
                ],
                'too_long_titles' => [
                    'count' => $tooLongTitles,
                    'severity' => 'low',
                    'message' => 'Meta titles exceeding 60 characters',
                ],
                'too_long_descriptions' => [
                    'count' => $tooLongDescriptions,
                    'severity' => 'low',
                    'message' => 'Meta descriptions exceeding 160 characters',
                ],
            ],
            'score' => $this->calculateSeoScore($seoDataCount, $missingDescriptions, $missingKeywords, $missingImages, $tooLongTitles, $tooLongDescriptions),
        ]);
    }

    /**
     * Calculate SEO score.
     */
    protected function calculateSeoScore($total, $missingDesc, $missingKeywords, $missingImages, $wrongTitleLength, $wrongDescLength): int
    {
        if ($total === 0) return 0;

        $issues = (($missingDesc * 5) + ($missingKeywords * 3) + ($missingImages * 2) + ($wrongTitleLength * 2) + ($wrongDescLength * 1));
        $maxIssues = $total * 10;
        $score = 100 - (($issues / $maxIssues) * 100);

        return max(0, (int)$score);
    }
}

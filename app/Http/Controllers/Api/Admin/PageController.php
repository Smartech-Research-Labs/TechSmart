<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Get all pages.
     */
    public function index()
    {
        $pages = Page::with('sections')->orderBy('created_at', 'desc')->get();

        return response()->json(['pages' => $pages]);
    }

    /**
     * Store a new page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug',
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $page = Page::create($data);

        Cache::forget('pages');

        return response()->json([
            'message' => 'Page created successfully',
            'page' => $page->load('sections'),
        ], 201);
    }

    /**
     * Get a single page by ID with all sections.
     */
    public function show(Page $page)
    {
        return response()->json(['page' => $page->load('sections')]);
    }

    /**
     * Get a page by slug (for public viewing).
     */
    public function showBySlug(string $slug)
    {
        $page = Cache::remember("page_{$slug}", 3600, function () use ($slug) {
            return Page::with(['sections' => function ($query) {
                $query->where('is_visible', true)->orderBy('order');
            }])
                ->where('slug', $slug)
                ->where('is_published', true)
                ->firstOrFail();
        });

        return response()->json(['page' => $page]);
    }

    /**
     * Update a page.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:pages,slug,' . $page->id,
            'description' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'og_image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        if (isset($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $page->update($data);

        Cache::forget('pages');
        Cache::forget("page_{$page->slug}");

        return response()->json([
            'message' => 'Page updated successfully',
            'page' => $page->load('sections'),
        ]);
    }

    /**
     * Delete a page.
     */
    public function destroy(Page $page)
    {
        $slug = $page->slug;
        $page->delete();

        Cache::forget('pages');
        Cache::forget("page_{$slug}");

        return response()->json(['message' => 'Page deleted successfully']);
    }

    /**
     * Add a section to a page.
     */
    public function addSection(Request $request, Page $page)
    {
        $request->validate([
            'section_type' => 'required|string',
            'heading' => 'nullable|string',
            'subheading' => 'nullable|string',
            'description' => 'nullable|string',
            'background_image' => 'nullable|string',
            'background_color' => 'nullable|string',
            'cta_label' => 'nullable|string',
            'cta_url' => 'nullable|string',
            'cta_label_2' => 'nullable|string',
            'cta_url_2' => 'nullable|string',
            'settings' => 'nullable|array',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $section = $page->sections()->create($request->all());

        Cache::forget("page_{$page->slug}");

        return response()->json([
            'message' => 'Section added successfully',
            'section' => $section,
        ], 201);
    }

    /**
     * Update a section.
     */
    public function updateSection(Request $request, PageSection $section)
    {
        $request->validate([
            'section_type' => 'required|string',
            'heading' => 'nullable|string',
            'subheading' => 'nullable|string',
            'description' => 'nullable|string',
            'background_image' => 'nullable|string',
            'background_color' => 'nullable|string',
            'cta_label' => 'nullable|string',
            'cta_url' => 'nullable|string',
            'cta_label_2' => 'nullable|string',
            'cta_url_2' => 'nullable|string',
            'settings' => 'nullable|array',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $section->update($request->all());

        Cache::forget("page_{$section->page->slug}");

        return response()->json([
            'message' => 'Section updated successfully',
            'section' => $section,
        ]);
    }

    /**
     * Delete a section.
     */
    public function destroySection(PageSection $section)
    {
        $pageSlug = $section->page->slug;
        $section->delete();

        Cache::forget("page_{$pageSlug}");

        return response()->json(['message' => 'Section deleted successfully']);
    }

    /**
     * Reorder sections on a page.
     */
    public function reorderSections(Request $request, Page $page)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:page_sections,id',
            'sections.*.order' => 'required|integer',
        ]);

        foreach ($request->sections as $sectionData) {
            PageSection::where('id', $sectionData['id'])
                ->where('page_id', $page->id)
                ->update(['order' => $sectionData['order']]);
        }

        Cache::forget("page_{$page->slug}");

        return response()->json(['message' => 'Sections reordered successfully']);
    }
}

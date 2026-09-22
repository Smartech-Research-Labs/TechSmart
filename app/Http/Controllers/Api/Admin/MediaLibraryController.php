<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use App\Services\AISeoBulkUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;
use Intervention\Image\ImageManager;

class MediaLibraryController extends Controller
{
    protected AISeoBulkUpdateService $aiService;

    public function __construct(AISeoBulkUpdateService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Get all media with pagination and filters
     */
    public function index(Request $request)
    {
        $query = MediaLibrary::query();

        // Filter by folder
        if ($request->has('folder') && $request->folder !== 'all') {
            $query->where('folder', $request->folder);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhere('title', 'like', $search)
                    ->orWhere('alt_text', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $perPage = $request->get('per_page', 24);
        $media = $query->paginate($perPage);

        return response()->json([
            'data' => $media->items(),
            'total' => $media->total(),
            'per_page' => $media->perPage(),
            'current_page' => $media->currentPage(),
            'last_page' => $media->lastPage(),
        ]);
    }

    /**
     * Get a single media item
     */
    public function show(MediaLibrary $mediaLibrary)
    {
        return response()->json($mediaLibrary);
    }

    /**
     * Update media metadata
     */
    public function update(Request $request, MediaLibrary $mediaLibrary)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
        ]);

        $mediaLibrary->update($validated);

        return response()->json([
            'message' => 'Media updated successfully',
            'data' => $mediaLibrary,
        ]);
    }

    /**
     * Bulk update media metadata
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'updates' => 'required|array',
            'updates.*.id' => 'required|exists:media_library,id',
            'updates.*.title' => 'nullable|string|max:255',
            'updates.*.description' => 'nullable|string',
            'updates.*.alt_text' => 'nullable|string|max:255',
            'updates.*.caption' => 'nullable|string',
        ]);

        $results = [];
        foreach ($validated['updates'] as $update) {
            $id = $update['id'];
            $media = MediaLibrary::find($id);
            
            $data = [
                'title' => $update['title'] ?? $media->title,
                'description' => $update['description'] ?? $media->description,
                'alt_text' => $update['alt_text'] ?? $media->alt_text,
                'caption' => $update['caption'] ?? $media->caption,
            ];

            $media->update($data);
            $results[] = $media;
        }

        return response()->json([
            'message' => count($results) . ' media items updated successfully',
            'data' => $results,
        ]);
    }

    /**
     * Generate SEO metadata using AI for single media
     */
    public function generateSeoMetadata(Request $request, MediaLibrary $mediaLibrary)
    {
        $context = $request->get('context');

        try {
            $metadata = $this->aiService->generateMetadata(
                ['id' => $mediaLibrary->id, 'name' => $mediaLibrary->name, 'path' => $mediaLibrary->path],
                $context
            );

            $mediaLibrary->update($metadata);

            return response()->json([
                'message' => 'SEO metadata generated successfully',
                'data' => $mediaLibrary,
            ]);
        } catch (Exception $e) {
            Log::error('Media SEO metadata generation failed', ['media_id' => $mediaLibrary->id, 'error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to generate metadata',
            ], 500);
        }
    }

    /**
     * Bulk generate SEO metadata using AI
     */
    public function bulkGenerateSeoMetadata(Request $request)
    {
        $validated = $request->validate([
            'media_ids' => 'required|array',
            'media_ids.*' => 'exists:media_library,id',
            'context' => 'nullable|string',
            'type' => 'nullable|in:generic,services,industries',
        ]);

        $mediaIds = $validated['media_ids'];
        $context = $validated['context'];
        $type = $validated['type'] ?? 'generic';

        try {
            $images = MediaLibrary::whereIn('id', $mediaIds)->get()->map(fn ($m) => [
                'id' => $m->id,
                'name' => $m->name,
                'path' => $m->path,
            ])->toArray();

            // Generate metadata based on type
            if ($type === 'services') {
                $results = $this->aiService->generateForServices($images);
            } else {
                $results = $this->aiService->generateBulkMetadata($images, $context);
            }

            // Update media items with generated metadata
            $updated = [];
            foreach ($results as $result) {
                if ($result['success']) {
                    $media = MediaLibrary::find($result['id']);
                    $media->update($result['data']);
                    $updated[] = $media;
                }
            }

            return response()->json([
                'message' => count($updated) . ' media items updated with AI-generated metadata',
                'data' => $updated,
                'results' => $results,
            ]);
        } catch (Exception $e) {
            Log::error('Bulk media SEO metadata generation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Bulk generation failed',
            ], 500);
        }
    }

    /**
     * Delete a media item
     */
    public function destroy(MediaLibrary $mediaLibrary)
    {
        try {
            // Delete the file from storage
            if (Storage::disk('public')->exists($mediaLibrary->path)) {
                Storage::disk('public')->delete($mediaLibrary->path);
            }

            $mediaLibrary->delete();

            return response()->json([
                'message' => 'Media deleted successfully',
            ]);
        } catch (Exception $e) {
            Log::error('Media deletion failed', ['media_id' => $mediaLibrary->id, 'error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to delete media',
            ], 500);
        }
    }

    /**
     * Get folder statistics
     */
    public function getFolderStats()
    {
        $stats = MediaLibrary::selectRaw('folder, COUNT(*) as count, SUM(file_size) as total_size')
            ->groupBy('folder')
            ->get();

        return response()->json($stats);
    }

    /**
     * Scan resources/img folder and import images to media library
     */
    public function scanAndImport(Request $request)
    {
        $imported = [];
        $skipped = [];

        try {
            $folders = ['img', 'img/services'];

            foreach ($folders as $folder) {
                $path = resource_path($folder);
                
                if (!is_dir($path)) {
                    continue;
                }

                $files = scandir($path);
                $folder_key = $folder === 'img' ? 'resources' : 'services';

                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    }

                    $filePath = $path . '/' . $file;
                    
                    if (!is_file($filePath)) {
                        continue;
                    }

                    // Check if file is an image
                    if (!preg_match('/\.(jpg|jpeg|png|gif|svg|webp|avif)$/i', $file)) {
                        continue;
                    }

                    // Check if already in media library
                    $relativePath = 'resources/' . $folder . '/' . $file;
                    if (MediaLibrary::where('path', $relativePath)->exists()) {
                        $skipped[] = $file;
                        continue;
                    }

                    // Get image dimensions
                    $dimensions = @getimagesize($filePath);
                    $width = $dimensions[0] ?? null;
                    $height = $dimensions[1] ?? null;

                    // Create media entry
                    $media = MediaLibrary::create([
                        'name' => $file,
                        'path' => $relativePath,
                        'url' => '/storage/resources/' . $folder . '/' . $file,
                        'mime_type' => mime_content_type($filePath),
                        'file_size' => filesize($filePath),
                        'folder' => $folder_key,
                        'image_width' => $width,
                        'image_height' => $height,
                    ]);

                    $imported[] = [
                        'name' => $file,
                        'id' => $media->id,
                    ];
                }
            }

            return response()->json([
                'message' => 'Scan completed',
                'imported_count' => count($imported),
                'skipped_count' => count($skipped),
                'imported' => $imported,
                'skipped' => $skipped,
            ]);
        } catch (Exception $e) {
            Log::error('Media library scan and import failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Scan and import failed',
            ], 500);
        }
    }
}

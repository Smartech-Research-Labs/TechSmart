<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * List all uploaded media files (gallery).
     */
    public function index(Request $request)
    {
        $folder = $request->get('folder', 'media');
        $files = Storage::disk('public')->files($folder);

        // Also scan common upload folders
        $allFiles = collect();
        foreach (['media', 'logos', 'images', 'uploads'] as $dir) {
            if (Storage::disk('public')->exists($dir)) {
                foreach (Storage::disk('public')->files($dir) as $file) {
                    $allFiles->push($file);
                }
            }
        }

        // Only image files
        $images = $allFiles->unique()->filter(function ($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|svg|webp|avif)$/i', $file);
        })->values()->map(function ($file) {
            return [
                'path' => $file,
                'url' => Storage::url($file),
                'name' => basename($file),
                'size' => Storage::disk('public')->size($file),
                'last_modified' => Storage::disk('public')->lastModified($file),
            ];
        })->sortByDesc('last_modified')->values();

        return response()->json(['images' => $images]);
    }

    /**
     * Upload an image with optional WebP conversion.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg,webp,avif|max:10240',
            'folder' => 'nullable|string|max:50',
            'convert_webp' => 'nullable|boolean',
        ]);

        $file = $request->file('image');
        $folder = $request->get('folder', 'media');
        $convertWebp = $request->boolean('convert_webp', true);

        $extension = strtolower($file->getClientOriginalExtension());
        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $baseName = $baseName ?: Str::random(12);

        // Convert to WebP if requested and the image is not already webp/svg
        if ($convertWebp && !in_array($extension, ['webp', 'svg'])) {
            try {
                $imageData = file_get_contents($file->getRealPath());
                $gdImage = @imagecreatefromstring($imageData);

                if ($gdImage !== false) {
                    $webpName = $baseName . '-' . time() . '.webp';
                    $tempPath = sys_get_temp_dir() . '/' . $webpName;

                    // Preserve transparency for PNG
                    imagepalettetotruecolor($gdImage);
                    imagealphablending($gdImage, true);
                    imagesavealpha($gdImage, true);

                    imagewebp($gdImage, $tempPath, 85);
                    imagedestroy($gdImage);

                    $storedPath = $folder . '/' . $webpName;
                    Storage::disk('public')->put($storedPath, file_get_contents($tempPath));
                    @unlink($tempPath);

                    return response()->json([
                        'message' => 'Image uploaded and converted to WebP',
                        'path' => $storedPath,
                        'url' => Storage::url($storedPath),
                        'format' => 'webp',
                    ]);
                }
            } catch (\Throwable $e) {
                // Fall through to regular upload if conversion fails
            }
        }

        // Regular upload (no conversion or SVG/WebP already)
        $fileName = $baseName . '-' . time() . '.' . $extension;
        $storedPath = $file->storeAs($folder, $fileName, 'public');

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $storedPath,
            'url' => Storage::url($storedPath),
            'format' => $extension,
        ]);
    }

    /**
     * Delete a media file.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->path;
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return response()->json(['message' => 'File deleted']);
        }

        return response()->json(['message' => 'File not found'], 404);
    }

    /**
     * Bulk upload multiple images.
     */
    public function uploadMultiple(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:png,jpg,jpeg,gif,svg,webp,avif|max:10240',
            'folder' => 'nullable|string|max:50',
            'convert_webp' => 'nullable|boolean',
        ]);

        $folder = $request->get('folder', 'media');
        $convertWebp = $request->boolean('convert_webp', true);
        $uploaded = [];

        foreach ($request->file('images') as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $baseName = $baseName ?: Str::random(12);

            if ($convertWebp && !in_array($extension, ['webp', 'svg'])) {
                try {
                    $imageData = file_get_contents($file->getRealPath());
                    $gdImage = @imagecreatefromstring($imageData);

                    if ($gdImage !== false) {
                        $webpName = $baseName . '-' . time() . '-' . uniqid() . '.webp';
                        $tempPath = sys_get_temp_dir() . '/' . $webpName;

                        imagepalettetotruecolor($gdImage);
                        imagealphablending($gdImage, true);
                        imagesavealpha($gdImage, true);

                        imagewebp($gdImage, $tempPath, 85);
                        imagedestroy($gdImage);

                        $storedPath = $folder . '/' . $webpName;
                        Storage::disk('public')->put($storedPath, file_get_contents($tempPath));
                        @unlink($tempPath);

                        $uploaded[] = [
                            'path' => $storedPath,
                            'url' => Storage::url($storedPath),
                            'format' => 'webp',
                        ];
                        continue;
                    }
                } catch (\Throwable $e) {
                    // Fall through to regular upload
                }
            }

            $fileName = $baseName . '-' . time() . '-' . uniqid() . '.' . $extension;
            $storedPath = $file->storeAs($folder, $fileName, 'public');

            $uploaded[] = [
                'path' => $storedPath,
                'url' => Storage::url($storedPath),
                'format' => $extension,
            ];
        }

        return response()->json([
            'message' => count($uploaded) . ' image(s) uploaded successfully',
            'images' => $uploaded,
        ]);
    }

    /**
     * Bulk delete multiple media files.
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'paths' => 'required|array',
            'paths.*' => 'required|string',
        ]);

        $deleted = [];
        $notFound = [];

        foreach ($request->paths as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                $deleted[] = $path;
            } else {
                $notFound[] = $path;
            }
        }

        return response()->json([
            'message' => count($deleted) . ' file(s) deleted' . (count($notFound) ? ', ' . count($notFound) . ' not found' : ''),
            'deleted' => $deleted,
            'not_found' => $notFound,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MediaLibrary extends Model
{
    use HasFactory;

    protected $table = 'media_library';

    protected $fillable = [
        'name',
        'path',
        'url',
        'mime_type',
        'file_size',
        'title',
        'description',
        'alt_text',
        'caption',
        'image_width',
        'image_height',
        'folder',
        'usage_count',
        'used_in',
    ];

    protected $casts = [
        'used_in' => 'array',
        'usage_count' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Get industries that use this media
     */
    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class, 'industry_media', 'media_id', 'industry_id');
    }

    /**
     * Scope to get images by folder
     */
    public function scopeInFolder($query, $folder)
    {
        return $query->where('folder', $folder);
    }

    /**
     * Scope to get only images with SEO metadata
     */
    public function scopeWithMetadata($query)
    {
        return $query->whereNotNull('alt_text')->orWhereNotNull('title');
    }

    /**
     * Get the full URL for the media
     */
    public function getFullUrlAttribute(): string
    {
        return $this->url ?? '/storage/' . $this->path;
    }

    /**
     * Format file size for display
     */
    public function getFormattedSizeAttribute(): string
    {
        $size = $this->file_size ?? 0;
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = max($size, 0);
        $pow = floor(($size ? log($size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $size /= (1 << (10 * $pow));

        return round($size, 2) . ' ' . $units[$pow];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'short_description', 'description',
        'icon', 'image', 'banner_image',
        'sub_sectors', 'process_steps', 'features', 'stats',
        'cta_title', 'cta_description',
        'meta_title', 'meta_description',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'sub_sectors'   => 'array',
        'process_steps' => 'array',
        'features'      => 'array',
        'stats'         => 'array',
        'is_active'     => 'boolean',
    ];

    /**
     * Get media associated with this industry
     */
    public function media(): BelongsToMany
    {
        return $this->belongsToMany(MediaLibrary::class, 'industry_media', 'industry_id', 'media_id')
            ->withPivot('type')
            ->withTimestamps();
    }

    /**
     * Get the main card image
     */
    public function cardImage()
    {
        return $this->media()->wherePivot('type', 'image')->first();
    }

    /**
     * Get the banner image
     */
    public function bannerImageMedia()
    {
        return $this->media()->wherePivot('type', 'banner')->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'category',
        'image',
        'features',
        'specifications',
        'pricing_tiers',
        'is_featured',
        'is_published',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'specifications' => 'array',
            'pricing_tiers' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return '/storage/' . ltrim($this->image, '/');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function enquiries(): MorphMany
    {
        return $this->morphMany(Enquiry::class, 'enquirable');
    }

    public function wishlists(): MorphToMany
    {
        return $this->morphToMany(User::class, 'wishlistable', 'wishlists');
    }
}

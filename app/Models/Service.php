<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'image',
        'category',
        'category_group',
        'price_from',
        'price_label',
        'features',
        'process_steps',
        'is_featured',
        'is_published',
        'order',
    ];

    /**
     * Get the public image URL.
     */
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

    protected $appends = ['image_url'];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'process_steps' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'price_from' => 'decimal:2',
        ];
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

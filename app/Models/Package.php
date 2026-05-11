<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Package extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'tier_level',
        'price',
        'price_label',
        'image',
        'highlight_text',
        'features',
        'includes',
        'is_featured',
        'is_published',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'includes' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'price' => 'decimal:2',
        ];
    }

    // Auto-generate slug from name
    protected static function booted(): void
    {
        static::creating(function (Package $package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name);
            }
        });
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

    public function packageFeatures(): HasMany
    {
        return $this->hasMany(PackageFeature::class)->orderBy('order');
    }

    public function enquiries(): MorphMany
    {
        return $this->morphMany(Enquiry::class, 'enquirable');
    }

    public function wishlists(): MorphToMany
    {
        return $this->morphToMany(User::class, 'wishlistable', 'wishlists');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}

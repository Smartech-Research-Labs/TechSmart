<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CaseStudy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'client_name',
        'client_logo',
        'industry',
        'service_id',
        'service_ids',
        'challenge',
        'solution',
        'results',
        'metrics',
        'technologies',
        'testimonial_quote',
        'testimonial_author',
        'testimonial_role',
        'seo_title',
        'seo_description',
        'is_published',
        'is_featured',
        'published_at',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'service_ids' => 'array',
            'metrics' => 'array',
            'technologies' => 'array',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (CaseStudy $cs) {
            if (empty($cs->slug)) {
                $cs->slug = Str::slug($cs->title);
            }
        });
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('published_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->featured_image) {
            return null;
        }

        if (str_starts_with($this->featured_image, 'http')) {
            return $this->featured_image;
        }

        return asset('storage/' . $this->featured_image);
    }

    public function getReadingTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags(
            ($this->content ?? '') . ($this->challenge ?? '') . ($this->solution ?? '') . ($this->results ?? '')
        ));

        return max(1, (int) ceil($wordCount / 200));
    }
}

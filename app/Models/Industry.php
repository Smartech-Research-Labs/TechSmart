<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

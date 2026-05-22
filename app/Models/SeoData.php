<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoData extends Model
{
    use SoftDeletes;

    protected $table = 'seo_data';

    protected $fillable = [
        'page_name',
        'route_name',
        'page_type',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_type',
        'schema_markup',
        'index',
        'follow',
    ];

    protected $casts = [
        'index' => 'boolean',
        'follow' => 'boolean',
    ];

    /**
     * Scope to get SEO data by page name.
     */
    public function scopeByPageName($query, $pageName)
    {
        return $query->where('page_name', $pageName)->first();
    }

    /**
     * Scope to get SEO data by route name.
     */
    public function scopeByRouteName($query, $routeName)
    {
        return $query->where('route_name', $routeName)->first();
    }

    /**
     * Get the robots meta tag value.
     */
    public function getRobotsMetaAttribute(): string
    {
        $robots = [];
        
        if ($this->index) {
            $robots[] = 'index';
        } else {
            $robots[] = 'noindex';
        }
        
        if ($this->follow) {
            $robots[] = 'follow';
        } else {
            $robots[] = 'nofollow';
        }
        
        return implode(', ', $robots);
    }
}

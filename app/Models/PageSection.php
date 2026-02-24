<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = [
        'page_id',
        'section_type',
        'heading',
        'subheading',
        'description',
        'background_image',
        'background_color',
        'cta_label',
        'cta_url',
        'cta_label_2',
        'cta_url_2',
        'settings',
        'is_visible',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}

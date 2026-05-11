<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'image',
        'domain',
        'caption',
        'website_url',
        'is_visible',
        'is_seeded',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'is_seeded' => 'boolean',
        ];
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true)->orderBy('order');
    }
}

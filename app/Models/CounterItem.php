<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterItem extends Model
{
    protected $fillable = [
        'label',
        'number',
        'suffix',
        'icon',
        'is_visible',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true)->orderBy('order');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapDataPoint extends Model
{
    protected $fillable = [
        'county',
        'project_name',
        'latitude',
        'longitude',
        'intensity',
        'description',
        'year',
        'metadata',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'metadata' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}

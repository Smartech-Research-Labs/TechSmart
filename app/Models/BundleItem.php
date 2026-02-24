<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BundleItem extends Model
{
    protected $fillable = [
        'bundle_id',
        'bundleable_type',
        'bundleable_id',
        'quantity',
    ];

    public function bundle(): BelongsTo
    {
        return $this->belongsTo(Bundle::class);
    }

    public function bundleable(): MorphTo
    {
        return $this->morphTo();
    }
}

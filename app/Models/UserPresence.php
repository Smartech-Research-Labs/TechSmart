<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPresence extends Model
{
    protected $table = 'user_presence';

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'is_online',
        'last_seen_at',
    ];

    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set user online.
     */
    public static function online(int $userId): void
    {
        static::updateOrCreate(
            ['user_id' => $userId],
            ['is_online' => true, 'last_seen_at' => now()]
        );
    }

    /**
     * Set user offline.
     */
    public static function offline(int $userId): void
    {
        static::updateOrCreate(
            ['user_id' => $userId],
            ['is_online' => false, 'last_seen_at' => now()]
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectMessage extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'body',
        'attachment_url',
        'status',
        'delivered_at',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'delivered_at' => 'datetime',
            'read_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Mark this message as delivered (double tick).
     */
    public function markDelivered(): void
    {
        if ($this->status === 'sent') {
            $this->update([
                'status' => 'delivered',
                'delivered_at' => now(),
            ]);
        }
    }

    /**
     * Mark this message as read (blue/green ticks).
     */
    public function markRead(): void
    {
        if ($this->status !== 'read') {
            $this->update([
                'status' => 'read',
                'read_at' => now(),
                'delivered_at' => $this->delivered_at ?? now(),
            ]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_at',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DirectMessage::class)->orderBy('created_at');
    }

    public function latestMessage()
    {
        return $this->hasOne(DirectMessage::class)->latestOfMany();
    }

    /**
     * Get the other participant in the conversation.
     */
    public function getOtherUser(int $myId): ?User
    {
        return $this->user_one_id === $myId
            ? $this->userTwo
            : $this->userOne;
    }

    /**
     * Find or create a conversation between two users.
     */
    public static function between(int $userA, int $userB): self
    {
        $low = min($userA, $userB);
        $high = max($userA, $userB);

        return static::firstOrCreate(
            ['user_one_id' => $low, 'user_two_id' => $high]
        );
    }

    /**
     * Scope to conversations for a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId);
    }
}

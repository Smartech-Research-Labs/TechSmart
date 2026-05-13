<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CookieConsent extends Model
{
    protected $fillable = [
        'visitor_id',
        'email',
        'ip_address',
        'user_agent',
        'necessary_cookies',
        'analytics_cookies',
        'marketing_cookies',
        'accept_all',
        'source',
        'consent_date',
        'expires_at',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'necessary_cookies' => 'boolean',
            'analytics_cookies' => 'boolean',
            'marketing_cookies' => 'boolean',
            'accept_all' => 'boolean',
            'consent_date' => 'datetime',
            'expires_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user associated with this cookie consent.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get active consents (not expired).
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope to get users who accepted analytics.
     */
    public function scopeAnalyticsAccepted($query)
    {
        return $query->where('analytics_cookies', true);
    }

    /**
     * Scope to get users who accepted marketing.
     */
    public function scopeMarketingAccepted($query)
    {
        return $query->where('marketing_cookies', true);
    }

    /**
     * Scope to get users who accepted all cookies.
     */
    public function scopeAcceptedAll($query)
    {
        return $query->where('accept_all', true);
    }

    /**
     * Check if consent is still valid.
     */
    public function isValid(): bool
    {
        if ($this->expires_at === null) {
            return true;
        }

        return $this->expires_at->isFuture();
    }

    /**
     * Update cookie preferences.
     */
    public static function recordConsent(array $data): self
    {
        $visitorId = $data['visitor_id'] ?? null;
        $email = $data['email'] ?? null;

        // Try to find existing consent for this visitor
        $existing = null;
        if ($visitorId) {
            $existing = self::where('visitor_id', $visitorId)->latest()->first();
        } elseif ($email) {
            $existing = self::where('email', $email)->latest()->first();
        }

        // Set expiration (12 months from now)
        $expiresAt = now()->addMonths(12);

        if ($existing) {
            $existing->update([
                'necessary_cookies' => $data['necessary_cookies'] ?? true,
                'analytics_cookies' => $data['analytics_cookies'] ?? false,
                'marketing_cookies' => $data['marketing_cookies'] ?? false,
                'accept_all' => $data['accept_all'] ?? false,
                'expires_at' => $expiresAt,
            ]);
            return $existing;
        }

        return self::create([
            'visitor_id' => $visitorId,
            'email' => $email,
            'ip_address' => $data['ip_address'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'necessary_cookies' => $data['necessary_cookies'] ?? true,
            'analytics_cookies' => $data['analytics_cookies'] ?? false,
            'marketing_cookies' => $data['marketing_cookies'] ?? false,
            'accept_all' => $data['accept_all'] ?? false,
            'source' => $data['source'] ?? null,
            'user_id' => $data['user_id'] ?? null,
            'expires_at' => $expiresAt,
        ]);
    }
}

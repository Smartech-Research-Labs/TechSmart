<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'email',
        'password',
        'phone',
        'company',
        'bio',
        'avatar',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'country',
        'timezone',
        'language',
        'social_links',
        'notification_preferences',
        'last_login_at',
        'last_login_ip',
        'status',
        'google_id',
        'two_factor_email_code',
        'two_factor_email_expires_at',
        'two_factor_email_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_email_code',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
            'social_links' => 'array',
            'notification_preferences' => 'array',
        ];
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->avatar) {
            return str_starts_with($this->avatar, 'http') ? $this->avatar : '/storage/' . $this->avatar;
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff&size=128';
    }

    public function getProfileCompletionAttribute(): int
    {
        $fields = ['name', 'email', 'phone', 'company', 'bio', 'avatar', 'date_of_birth', 'address', 'city', 'country'];
        $filled = collect($fields)->filter(fn ($f) => !empty($this->$f))->count();
        return (int) round(($filled / count($fields)) * 100);
    }

    public function loginHistories(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function chatSessions(): HasMany
    {
        return $this->hasMany(ChatSession::class);
    }

    public function wishlistedProducts(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'wishlistable', 'wishlists');
    }

    public function wishlistedServices(): MorphToMany
    {
        return $this->morphedByMany(Service::class, 'wishlistable', 'wishlists');
    }

    public function presence(): HasOne
    {
        return $this->hasOne(UserPresence::class);
    }

    public function conversations()
    {
        return Conversation::forUser($this->id);
    }
}

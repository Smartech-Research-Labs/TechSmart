<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return response()->json(['url' => $url]);
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect(config('app.frontend_url', config('app.url')) . '/login?error=google_auth_failed');
        }

        // Find user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Link google_id if not already linked
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => null,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]);

            // Assign default role
            if (method_exists($user, 'assignRole')) {
                $user->assignRole('user');
            }
        }

        // Record login history
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        LoginHistory::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device' => $this->parseDevice($request->userAgent()),
            'browser' => $this->parseBrowser($request->userAgent()),
            'platform' => $this->parsePlatform($request->userAgent()),
            'logged_in_at' => now(),
        ]);

        // Create Sanctum token
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        // Redirect back to frontend with token
        $frontendUrl = config('app.frontend_url', config('app.url'));

        return redirect("{$frontendUrl}/auth/google/callback?token={$token}");
    }

    private function parseDevice(?string $ua): string
    {
        if (! $ua) return 'Unknown';
        if (preg_match('/Mobile|Android|iPhone|iPad/i', $ua)) return 'Mobile';
        if (preg_match('/Tablet|iPad/i', $ua)) return 'Tablet';
        return 'Desktop';
    }

    private function parseBrowser(?string $ua): string
    {
        if (! $ua) return 'Unknown';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Safari')) return 'Safari';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR')) return 'Opera';
        return 'Other';
    }

    private function parsePlatform(?string $ua): string
    {
        if (! $ua) return 'Unknown';
        if (str_contains($ua, 'Windows')) return 'Windows';
        if (str_contains($ua, 'Mac')) return 'macOS';
        if (str_contains($ua, 'Linux')) return 'Linux';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iOS') || str_contains($ua, 'iPhone')) return 'iOS';
        return 'Other';
    }
}

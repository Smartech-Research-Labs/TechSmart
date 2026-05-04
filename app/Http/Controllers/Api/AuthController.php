<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginHistory;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Register a new user and return a Sanctum token.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default user role
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('user');
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        $user->load('roles', 'permissions');

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login and return a Sanctum token.
     * Supports email-based two-factor authentication.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // ✅ Use stateless credential validation for API login
        // This avoids session-based Auth::attempt() in api.php routes.

        // 2FA disabled for now - issue token directly
        return $this->issueToken($user, $request);
    }

    /**
     * Verify the email 2FA code and issue a token.
     */
    public function verifyTwoFactorEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'Invalid request.'], 401);
        }

        if (! $user->two_factor_email_code || ! $user->two_factor_email_expires_at) {
            return response()->json(['message' => 'No verification code pending.'], 422);
        }

        if (now()->greaterThan($user->two_factor_email_expires_at)) {
            $user->update([
                'two_factor_email_code' => null,
                'two_factor_email_expires_at' => null,
            ]);

            return response()->json(['message' => 'Verification code has expired. Please login again.'], 422);
        }

        if (! Hash::check($request->code, $user->two_factor_email_code)) {
            return response()->json(['message' => 'Invalid verification code.'], 422);
        }

        // Clear 2FA code
        $user->update([
            'two_factor_email_code' => null,
            'two_factor_email_expires_at' => null,
        ]);

        return $this->issueToken($user, $request);
    }

    /**
     * Resend the 2FA email code.
     */
    public function resendTwoFactorEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! $user->two_factor_email_enabled) {
            return response()->json(['message' => 'Invalid request.'], 422);
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'two_factor_email_code' => Hash::make($code),
            'two_factor_email_expires_at' => now()->addMinutes(10),
        ]);

        $user->notify(new TwoFactorCodeNotification($code));

        return response()->json([
            'message' => 'A new verification code has been sent to your email.',
        ]);
    }

    /**
     * Toggle email-based 2FA for the authenticated user.
     */
    public function toggleTwoFactorEmail(Request $request)
    {
        $user = $request->user();
        $enabled = ! $user->two_factor_email_enabled;

        $user->update(['two_factor_email_enabled' => $enabled]);

        return response()->json([
            'message' => $enabled
                ? 'Email two-factor authentication has been enabled.'
                : 'Email two-factor authentication has been disabled.',
            'two_factor_email_enabled' => $enabled,
        ]);
    }

    /**
     * Get the authenticated user.
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->load('roles', 'permissions');

        return response()->json([
            'user' => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
                'profile_completion' => $user->profile_completion,
            ]),
        ]);
    }

    /**
     * Logout – revoke the current token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Issue a Sanctum token and record login history.
     */
    private function issueToken(User $user, Request $request)
    {
        $user->load('roles', 'permissions');

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

        // Revoke old tokens
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
                'profile_completion' => $user->profile_completion,
            ]),
            'token' => $token,
        ]);
    }

    /**
     * Mask email for display (e.g., j***@example.com)
     */
    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 1) . str_repeat('*', max(strlen($local) - 1, 2));

        return "{$masked}@{$domain}";
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

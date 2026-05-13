<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use App\Models\User;
use App\Notifications\CookieConsentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class CookieConsentController extends Controller
{
    /**
     * Save or update cookie consent preferences.
     */
    public function saveConsent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'necessary_cookies' => 'sometimes|boolean',
            'analytics_cookies' => 'sometimes|boolean',
            'marketing_cookies' => 'sometimes|boolean',
            'accept_all' => 'sometimes|boolean',
            'visitor_id' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = [
                'visitor_id' => $request->visitor_id ?? null,
                'email' => $request->email ?? null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'necessary_cookies' => $request->necessary_cookies ?? true,
                'analytics_cookies' => $request->analytics_cookies ?? false,
                'marketing_cookies' => $request->marketing_cookies ?? false,
                'accept_all' => $request->accept_all ?? false,
                'source' => $request->source ?? 'homepage',
                'user_id' => auth('sanctum')->id() ?? null,
            ];

            $consent = CookieConsent::recordConsent($data);

            // Log the action
            Log::info('Cookie consent saved', [
                'consent_id' => $consent->id,
                'analytics' => $consent->analytics_cookies,
                'marketing' => $consent->marketing_cookies,
                'ip' => $request->ip(),
            ]);

            // If they accepted marketing cookies, add to marketing list
            if ($request->marketing_cookies && $request->email) {
                // You can create a MarketingContact model or just use this
                // For now, just logging
                Log::info('User opted in to marketing', ['email' => $request->email]);
            }

            return response()->json([
                'message' => 'Cookie preferences saved successfully',
                'data' => $consent,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Cookie consent save error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to save cookie preferences',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cookie consent for current visitor.
     */
    public function getConsent(Request $request)
    {
        try {
            $visitorId = $request->visitor_id ?? null;
            $email = $request->email ?? null;

            $consent = null;

            if ($visitorId) {
                $consent = CookieConsent::where('visitor_id', $visitorId)
                    ->active()
                    ->latest()
                    ->first();
            }

            if (!$consent && $email) {
                $consent = CookieConsent::where('email', $email)
                    ->active()
                    ->latest()
                    ->first();
            }

            if ($consent) {
                return response()->json([
                    'data' => $consent,
                    'has_consent' => true,
                ], 200);
            }

            return response()->json([
                'has_consent' => false,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cookie consent fetch error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch cookie preferences',
            ], 500);
        }
    }

    /**
     * Get analytics about cookie consent (for admin).
     */
    public function getAnalytics(Request $request)
    {
        // Only for authenticated admins
        if (!auth('sanctum')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth('sanctum')->user();
        if (!$user->hasAnyRole(['admin', 'superadmin'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            $totalConsents = CookieConsent::active()->count();
            $analyticsAccepted = CookieConsent::active()->analyticsAccepted()->count();
            $marketingAccepted = CookieConsent::active()->marketingAccepted()->count();
            $acceptedAll = CookieConsent::active()->acceptedAll()->count();

            $percentageAnalytics = $totalConsents > 0 ? round(($analyticsAccepted / $totalConsents) * 100, 2) : 0;
            $percentageMarketing = $totalConsents > 0 ? round(($marketingAccepted / $totalConsents) * 100, 2) : 0;
            $percentageAcceptedAll = $totalConsents > 0 ? round(($acceptedAll / $totalConsents) * 100, 2) : 0;

            return response()->json([
                'total_consents' => $totalConsents,
                'analytics_accepted' => $analyticsAccepted,
                'analytics_accepted_percentage' => $percentageAnalytics,
                'marketing_accepted' => $marketingAccepted,
                'marketing_accepted_percentage' => $percentageMarketing,
                'accepted_all' => $acceptedAll,
                'accepted_all_percentage' => $percentageAcceptedAll,
                'last_30_days' => CookieConsent::active()
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count(),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cookie consent analytics error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch analytics',
            ], 500);
        }
    }

    /**
     * Get list of emails who accepted marketing.
     */
    public function getMarketingEmails(Request $request)
    {
        // Only for authenticated admins
        if (!auth('sanctum')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth('sanctum')->user();
        if (!$user->hasAnyRole(['admin', 'superadmin'])) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        try {
            $emails = CookieConsent::active()
                ->marketingAccepted()
                ->whereNotNull('email')
                ->distinct('email')
                ->pluck('email');

            return response()->json([
                'count' => $emails->count(),
                'emails' => $emails,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Marketing emails fetch error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch marketing emails',
            ], 500);
        }
    }

    /**
     * Revoke consent for a visitor (GDPR right to be forgotten).
     */
    public function revokeConsent(Request $request)
    {
        try {
            $visitorId = $request->visitor_id ?? null;
            $email = $request->email ?? null;

            if (!$visitorId && !$email) {
                return response()->json([
                    'message' => 'Either visitor_id or email is required',
                ], 422);
            }

            $query = CookieConsent::query();

            if ($visitorId) {
                $query->where('visitor_id', $visitorId);
            } elseif ($email) {
                $query->where('email', $email);
            }

            $deleted = $query->delete();

            Log::info('Cookie consent revoked', [
                'deleted_records' => $deleted,
                'visitor_id' => $visitorId,
                'email' => $email,
            ]);

            return response()->json([
                'message' => 'Cookie consent revoked successfully (GDPR)',
                'deleted_records' => $deleted,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Cookie consent revoke error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to revoke consent',
            ], 500);
        }
    }
}

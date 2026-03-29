<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $user->load('roles');

        // Return data directly for compatibility with frontend
        return response()->json([
            'data' => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
                'profile_completion' => $user->profile_completion,
                'member_since' => $user->created_at->diffForHumans(),
                'account_age_days' => $user->created_at->diffInDays(now()),
                'last_login_at' => $user->loginHistories()->latest('logged_in_at')->first()?->logged_in_at,
            ]),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|string|in:male,female,other,prefer_not_to_say',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:10',
            'social_links' => 'nullable|array',
            'social_links.twitter' => 'nullable|url|max:255',
            'social_links.linkedin' => 'nullable|url|max:255',
            'social_links.github' => 'nullable|url|max:255',
            'social_links.website' => 'nullable|url|max:255',
            'notification_preferences' => 'nullable|array',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => array_merge($user->fresh()->toArray(), [
                'profile_photo_url' => $user->fresh()->profile_photo_url,
                'profile_completion' => $user->fresh()->profile_completion,
            ]),
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        // Support both file upload and preset avatar URL
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'avatar_url' => 'nullable|url',
        ]);

        $user = auth()->user();

        // Handle preset avatar URL (e.g., from DiceBear)
        if ($request->has('avatar_url') && $request->avatar_url) {
            // Delete old file-based avatar if exists
            if ($user->avatar && !str_starts_with($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the URL directly as the avatar
            $user->update(['avatar' => $request->avatar_url]);

            return response()->json([
                'message' => 'Avatar updated successfully',
                'avatar_url' => $request->avatar_url,
                'user' => array_merge($user->fresh()->toArray(), [
                    'profile_photo_url' => $user->fresh()->profile_photo_url,
                ]),
            ]);
        }

        // Handle file upload
        if (!$request->hasFile('avatar')) {
            return response()->json([
                'message' => 'No avatar provided',
            ], 422);
        }

        // Delete old avatar if exists (only if it's a local file)
        if ($user->avatar && !str_starts_with($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return response()->json([
            'message' => 'Avatar uploaded successfully',
            'avatar_url' => '/storage/' . $path,
            'user' => array_merge($user->fresh()->toArray(), [
                'profile_photo_url' => $user->fresh()->profile_photo_url,
            ]),
        ]);
    }

    public function removeAvatar()
    {
        $user = auth()->user();

        // Only delete from storage if it's a local file (not a URL)
        if ($user->avatar && !str_starts_with($user->avatar, 'http') && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return response()->json([
            'message' => 'Avatar removed',
            'user' => array_merge($user->fresh()->toArray(), [
                'profile_photo_url' => $user->fresh()->profile_photo_url,
            ]),
        ]);
    }

    public function sessions()
    {
        $user = auth()->user();

        $loginHistory = $user->loginHistories()
            ->latest('logged_in_at')
            ->take(20)
            ->get()
            ->map(fn ($h) => [
                'id' => $h->id,
                'device' => $h->device,
                'browser' => $h->browser,
                'platform' => $h->platform,
                'ip_address' => $h->ip_address,
                'location' => $h->location,
                'logged_in_at' => $h->logged_in_at->toISOString(),
                'time_ago' => $h->logged_in_at->diffForHumans(),
            ]);

        return response()->json([
            'sessions' => $loginHistory,
        ]);
    }

    public function activityLog()
    {
        $user = auth()->user();

        $activities = collect();

        // Reviews
        $user->reviews()->latest()->take(10)->get()->each(function ($r) use ($activities) {
            $activities->push([
                'type' => 'review',
                'message' => "You left a {$r->rating}-star review",
                'time' => $r->created_at->diffForHumans(),
                'created_at' => $r->created_at->toISOString(),
            ]);
        });

        // Enquiries
        $user->enquiries()->latest()->take(10)->get()->each(function ($e) use ($activities) {
            $activities->push([
                'type' => 'enquiry',
                'message' => 'You submitted an enquiry',
                'time' => $e->created_at->diffForHumans(),
                'created_at' => $e->created_at->toISOString(),
            ]);
        });

        // Wishlists
        $user->wishlists()->latest()->take(10)->get()->each(function ($w) use ($activities) {
            $activities->push([
                'type' => 'wishlist',
                'message' => 'Item added to wishlist',
                'time' => $w->created_at->diffForHumans(),
                'created_at' => $w->created_at->toISOString(),
            ]);
        });

        return response()->json([
            'activities' => $activities->sortByDesc('created_at')->take(20)->values(),
        ]);
    }
}

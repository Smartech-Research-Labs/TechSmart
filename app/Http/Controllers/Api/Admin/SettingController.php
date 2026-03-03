<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Get all settings grouped by their group.
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group')->map(function ($items) {
            return $items->pluck('value', 'key');
        });

        return response()->json(['settings' => $settings]);
    }

    /**
     * Get settings as flat key-value object (for public use).
     */
    public function publicSettings()
    {
        $keys = [
            'site_name', 'tagline', 'contact_email', 'contact_phone',
            'address', 'city', 'country',
            'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'youtube_url', 'tiktok_url', 'whatsapp_number',
            'logo_path', 'favicon_path', 'marquee_text',
            'copyright_text',
            'theme_preset', 'theme_primary_color', 'theme_accent_color',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::get($key);
        }

        return response()->json(['settings' => $settings]);
    }

    /**
     * Update multiple settings at once.
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.group' => 'nullable|string',
        ]);

        foreach ($request->settings as $item) {
            Setting::set(
                $item['key'],
                $item['value'] ?? '',
                $item['group'] ?? 'general',
                $item['type'] ?? 'text'
            );
        }

        Cache::forget('settings');
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Settings updated successfully']);
    }

    /**
     * Upload the site logo.
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:4096',
        ]);

        // Delete old logo if exists
        $oldLogo = Setting::get('logo_path');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        $path = $request->file('logo')->store('logos', 'public');
        Setting::set('logo_path', $path, 'branding', 'image');

        Cache::forget('settings');
        Cache::forget('homepage_data');

        return response()->json([
            'message' => 'Logo uploaded successfully',
            'logo_url' => Storage::url($path),
            'logo_path' => $path,
        ]);
    }

    /**
     * Upload the site favicon.
     */
    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:png,jpg,jpeg,ico,svg|max:1024', // Favicons are typically small
        ]);

        // Delete old favicon if exists
        $oldFavicon = Setting::get('favicon_path');
        if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
            Storage::disk('public')->delete($oldFavicon);
        }

        $path = $request->file('favicon')->store('logos', 'public');
        Setting::set('favicon_path', $path, 'branding', 'image');

        Cache::forget('settings');
        Cache::forget('homepage_data');

        return response()->json([
            'message' => 'Favicon uploaded successfully',
            'favicon_url' => Storage::url($path),
            'favicon_path' => $path,
        ]);
    }
}

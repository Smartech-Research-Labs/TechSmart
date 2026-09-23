<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use App\Services\AiBlogGeneratorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AiBlogController extends Controller
{
    /**
     * Current automation status: whether it's enabled and a short history
     * of AI-generated posts, so the admin panel can show what's happened.
     */
    public function status()
    {
        return response()->json([
            'enabled' => Setting::get('ai_blog_automation_enabled', '1') === '1',
            'schedule' => 'Mondays & Thursdays, 09:00',
            'recent_posts' => Blog::orderByDesc('created_at')
                ->limit(10)
                ->get(['id', 'title', 'category', 'is_published', 'published_at', 'created_at']),
        ]);
    }

    /**
     * Toggle the automation on/off (checked by the scheduled command).
     */
    public function toggle(Request $request)
    {
        $validated = $request->validate(['enabled' => 'required|boolean']);

        Setting::set('ai_blog_automation_enabled', $validated['enabled'] ? '1' : '0', 'ai', 'boolean');

        return response()->json([
            'message' => 'Automation ' . ($validated['enabled'] ? 'enabled' : 'disabled') . '.',
            'enabled' => $validated['enabled'],
        ]);
    }

    /**
     * Generate one post right now, outside the Mon/Thu schedule.
     */
    public function generateNow(AiBlogGeneratorService $generator)
    {
        try {
            $blog = $generator->generate();

            return response()->json([
                'message' => 'Blog post generated and published.',
                'blog' => $blog,
            ], 201);
        } catch (Exception $e) {
            Log::error('Manual AI blog generation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Failed to generate blog post. Check that an OpenAI API key is configured in Settings > AI.',
            ], 500);
        }
    }
}

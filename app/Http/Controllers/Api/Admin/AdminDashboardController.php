<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Blog, Bundle, ChatSession, Enquiry, Product, Review, Service, User};
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'services' => Service::where('is_published', true)->count(),
            'products' => Product::where('is_published', true)->count(),
            'bundles' => Bundle::where('is_published', true)->count(),
            'blogs' => Blog::where('is_published', true)->count(),
            'enquiries' => Enquiry::count(),
            'reviews' => Review::count(),
            'users' => User::count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'new_enquiries' => Enquiry::where('status', 'new')->count(),
            'active_chats' => ChatSession::where('status', 'active')->count(),
        ]);
    }

    public function recentActivity()
    {
        $activity = collect();

        // Recent enquiries
        Enquiry::latest()->take(5)->get()->each(function ($e) use ($activity) {
            $activity->push([
                'type' => 'enquiry',
                'message' => "New enquiry from {$e->name}",
                'time' => $e->created_at->diffForHumans(),
                'created_at' => $e->created_at,
            ]);
        });

        // Recent reviews
        Review::with('user')->latest()->take(5)->get()->each(function ($r) use ($activity) {
            $activity->push([
                'type' => 'review',
                'message' => ($r->user?->name ?? 'Someone') . " left a {$r->rating}-star review",
                'time' => $r->created_at->diffForHumans(),
                'created_at' => $r->created_at,
            ]);
        });

        // Recent users
        User::latest()->take(5)->get()->each(function ($u) use ($activity) {
            $activity->push([
                'type' => 'user',
                'message' => "{$u->name} registered",
                'time' => $u->created_at->diffForHumans(),
                'created_at' => $u->created_at,
            ]);
        });

        return response()->json(
            $activity->sortByDesc('created_at')->take(10)->values()
        );
    }
}

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

    public function recentActivity(Request $request)
    {
        $limit = min((int) $request->query('limit', 50), 200);
        $perType = (int) ceil($limit / 3) + 5;

        $activity = collect();

        // Recent enquiries
        Enquiry::latest()->take($perType)->get()->each(function ($e) use ($activity) {
            $activity->push([
                'id' => 'enquiry-' . $e->id,
                'type' => 'enquiry',
                'message' => "New enquiry from {$e->name}",
                'detail' => $e->subject ?? $e->message ?? '',
                'user' => $e->name,
                'email' => $e->email ?? null,
                'time' => $e->created_at->diffForHumans(),
                'created_at' => $e->created_at->toISOString(),
            ]);
        });

        // Recent reviews
        Review::with('user')->latest()->take($perType)->get()->each(function ($r) use ($activity) {
            $activity->push([
                'id' => 'review-' . $r->id,
                'type' => 'review',
                'message' => ($r->user?->name ?? 'Someone') . " left a {$r->rating}-star review",
                'detail' => $r->comment ?? '',
                'user' => $r->user?->name ?? 'Anonymous',
                'email' => $r->user?->email ?? null,
                'time' => $r->created_at->diffForHumans(),
                'created_at' => $r->created_at->toISOString(),
            ]);
        });

        // Recent users
        User::latest()->take($perType)->get()->each(function ($u) use ($activity) {
            $activity->push([
                'id' => 'user-' . $u->id,
                'type' => 'user',
                'message' => "{$u->name} registered",
                'detail' => $u->email,
                'user' => $u->name,
                'email' => $u->email,
                'time' => $u->created_at->diffForHumans(),
                'created_at' => $u->created_at->toISOString(),
            ]);
        });

        return response()->json(
            $activity->sortByDesc('created_at')->take($limit)->values()
        );
    }

    public function notifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->take(50)->get()->map(fn ($n) => [
            'id' => $n->id,
            'message' => $n->data['message'] ?? '',
            'item_type' => $n->data['item_type'] ?? '',
            'item_name' => $n->data['item_name'] ?? '',
            'user_name' => $n->data['user_name'] ?? '',
            'read' => $n->read_at !== null,
            'time' => $n->created_at->diffForHumans(),
            'created_at' => $n->created_at->toISOString(),
        ]);

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markNotificationRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['message' => 'Notification marked as read']);
    }

    public function markAllNotificationsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read']);
    }

    public function markNotificationUnread($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->update(['read_at' => null]);
        }

        return response()->json(['message' => 'Notification marked as unread']);
    }

    public function deleteNotification($id)
    {
        auth()->user()->notifications()->where('id', $id)->delete();

        return response()->json(['message' => 'Notification deleted']);
    }

    public function deleteAllNotifications()
    {
        auth()->user()->notifications()->delete();

        return response()->json(['message' => 'All notifications deleted']);
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Blog, Bundle, ChatSession, Enquiry, LoginHistory, Product, Review, Service, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

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
            // Trend data
            'new_users_this_month' => User::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
            'new_users_last_month' => User::whereBetween('created_at', [$lastMonth->copy()->startOfMonth(), $lastMonth->copy()->endOfMonth()])->count(),
            'enquiries_this_month' => Enquiry::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
            'enquiries_last_month' => Enquiry::whereBetween('created_at', [$lastMonth->copy()->startOfMonth(), $lastMonth->copy()->endOfMonth()])->count(),
            'reviews_this_month' => Review::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
            // Chart data: users per month for last 6 months
            'users_chart' => $this->getUsersChart(),
            'enquiries_chart' => $this->getEnquiriesChart(),
        ]);
    }

    private function getUsersChart(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $data;
    }

    private function getEnquiriesChart(): array
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $data[] = [
                'month' => $date->format('M'),
                'count' => Enquiry::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        }
        return $data;
    }

    public function overview()
    {
        $user = auth()->user();

        return response()->json([
            'user' => array_merge($user->toArray(), [
                'profile_photo_url' => $user->profile_photo_url,
                'profile_completion' => $user->profile_completion,
                'member_since' => $user->created_at->diffForHumans(),
                'account_age_days' => $user->created_at->diffInDays(now()),
                'is_birthday' => $user->date_of_birth ? $user->date_of_birth->format('m-d') === now()->format('m-d') : false,
                'join_anniversary' => $user->created_at->format('m-d') === now()->format('m-d'),
            ]),
            'recent_logins' => LoginHistory::where('user_id', $user->id)
                ->latest('logged_in_at')
                ->take(5)
                ->get()
                ->map(fn ($h) => [
                    'device' => $h->device,
                    'browser' => $h->browser,
                    'platform' => $h->platform,
                    'ip_address' => $h->ip_address,
                    'time_ago' => $h->logged_in_at->diffForHumans(),
                ]),
            'system_health' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'storage_used' => $this->getStorageUsed(),
                'db_size' => $this->getDbSize(),
            ],
        ]);
    }

    private function getStorageUsed(): string
    {
        $path = storage_path('app/public');
        if (! is_dir($path)) return '0 MB';
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
            if ($file->isFile()) $size += $file->getSize();
        }
        return round($size / 1024 / 1024, 1) . ' MB';
    }

    private function getDbSize(): string
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS size FROM information_schema.tables WHERE table_schema = ?", [$dbName]);
            return ($result[0]->size ?? '0') . ' MB';
        } catch (\Exception $e) {
            return 'N/A';
        }
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

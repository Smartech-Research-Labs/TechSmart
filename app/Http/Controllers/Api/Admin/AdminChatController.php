<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\DirectMessage;
use App\Models\UserPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminChatController extends Controller
{
    public function sessions(Request $request)
    {
        $query = ChatSession::with(['user', 'assignedAdmin'])
            ->withCount(['messages', 'messages as unread_count' => function ($q) {
                $q->where('is_read', false)->where('sender_type', 'user');
            }])
            ->latest('last_message_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sessions = $query->paginate(20);

        return response()->json($sessions);
    }

    public function messages(ChatSession $session)
    {
        $messages = $session->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();

        // Mark all user messages as read
        $session->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function reply(Request $request, ChatSession $session)
    {
        $request->validate([
            'message' => 'required|string|min:1',
        ]);

        $message = ChatMessage::create([
            'chat_session_id' => $session->id,
            'user_id' => auth()->id(),
            'sender_type' => 'admin',
            'message' => $request->message,
        ]);

        $session->update([
            'status' => 'active',
            'assigned_to' => auth()->id(),
            'last_message_at' => now(),
        ]);

        return response()->json([
            'message' => 'Reply sent',
            'chat_message' => $message->load('user'),
        ]);
    }

    public function closeSession(ChatSession $session)
    {
        $session->update(['status' => 'closed']);

        return response()->json(['message' => 'Session closed']);
    }

    public function stats()
    {
        return response()->json([
            'total_sessions' => ChatSession::count(),
            'open_sessions' => ChatSession::where('status', 'active')->count(),
            'closed_sessions' => ChatSession::where('status', 'closed')->count(),
            'unread_messages' => ChatMessage::where('sender_type', 'user')->where('is_read', false)->count(),
        ]);
    }

    /**
     * Comprehensive chat metrics for admin dashboard
     */
    public function metrics()
    {
        $now = now();
        $today = $now->copy()->startOfDay();
        $thisWeek = $now->copy()->startOfWeek();
        $thisMonth = $now->copy()->startOfMonth();

        // Support chat metrics
        $supportStats = [
            'total_sessions' => ChatSession::count(),
            'active_sessions' => ChatSession::where('status', 'active')->count(),
            'closed_sessions' => ChatSession::where('status', 'closed')->count(),
            'unread_messages' => ChatMessage::where('sender_type', 'user')->where('is_read', false)->count(),
            'today_sessions' => ChatSession::where('created_at', '>=', $today)->count(),
            'today_messages' => ChatMessage::where('created_at', '>=', $today)->count(),
            'week_sessions' => ChatSession::where('created_at', '>=', $thisWeek)->count(),
            'week_messages' => ChatMessage::where('created_at', '>=', $thisMonth)->count(),
            'avg_messages_per_session' => round(
                ChatSession::withCount('messages')->get()->avg('messages_count') ?? 0,
                1
            ),
        ];

        // Direct messaging metrics
        $dmStats = [
            'total_conversations' => Conversation::count(),
            'total_messages' => DirectMessage::count(),
            'today_messages' => DirectMessage::where('created_at', '>=', $today)->count(),
            'week_messages' => DirectMessage::where('created_at', '>=', $thisWeek)->count(),
            'active_conversations' => Conversation::where('last_message_at', '>=', $now->copy()->subDays(7))->count(),
            'unread_messages' => DirectMessage::where('status', '!=', 'read')->count(),
        ];

        // User presence stats
        $presenceStats = [
            'online_users' => UserPresence::where('is_online', true)->count(),
            'recently_active' => UserPresence::where('last_seen_at', '>=', $now->copy()->subMinutes(30))->count(),
        ];

        // Activity timeline (messages per hour for the last 24 hours)
        $timeline = ChatMessage::where('created_at', '>=', $now->copy()->subHours(24))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $dmTimeline = DirectMessage::where('created_at', '>=', $now->copy()->subHours(24))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        // Merge timelines into 24-hour array
        $activityTimeline = [];
        for ($h = 0; $h < 24; $h++) {
            $activityTimeline[] = [
                'hour' => $h,
                'support' => $timeline[$h] ?? 0,
                'dm' => $dmTimeline[$h] ?? 0,
            ];
        }

        // Top active users (by DM count this week)
        $topUsers = DirectMessage::where('direct_messages.created_at', '>=', $thisWeek)
            ->join('users', 'direct_messages.sender_id', '=', 'users.id')
            ->select('users.id', 'users.name', DB::raw('COUNT(*) as message_count'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('message_count')
            ->limit(10)
            ->get();

        return response()->json([
            'support' => $supportStats,
            'dm' => $dmStats,
            'presence' => $presenceStats,
            'timeline' => $activityTimeline,
            'top_users' => $topUsers,
        ]);
    }
}

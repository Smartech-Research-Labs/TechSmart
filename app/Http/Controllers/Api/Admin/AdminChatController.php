<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

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
}

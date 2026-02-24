<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\{ChatSession, ChatMessage};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function sessions()
    {
        if (auth()->check()) {
            $sessions = auth()->user()
                ->chatSessions()
                ->with(['messages' => function ($query) {
                    $query->latest()->take(1);
                }])
                ->latest('last_message_at')
                ->get();
        } else {
            // Guest user - get by session token from cookie
            $sessionToken = request()->cookie('chat_session_token');
            $sessions = $sessionToken
                ? ChatSession::where('session_token', $sessionToken)->with('messages')->get()
                : [];
        }

        return response()->json($sessions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_email' => 'required_without:user_id|email|max:255',
        ]);

        $session = null;

        if (auth()->check()) {
            $session = ChatSession::firstOrCreate(
                ['user_id' => auth()->id(), 'status' => 'active'],
                ['session_token' => Str::random(32)]
            );
        } else {
            $sessionToken = $request->cookie('chat_session_token') ?? Str::random(32);
            $session = ChatSession::firstOrCreate(
                ['session_token' => $sessionToken],
                [
                    'guest_name' => $request->guest_name,
                    'guest_email' => $request->guest_email,
                ]
            );
        }

        $message = ChatMessage::create([
            'chat_session_id' => $session->id,
            'user_id' => auth()->id(),
            'sender_type' => auth()->check() ? 'user' : 'user',
            'message' => $request->message,
        ]);

        $session->update(['last_message_at' => now()]);

        // TODO: Broadcast Socket.IO event to admin
        // TODO: Queue BullMQ job if no admin responds in 5 min

        return response()->json([
            'message' => $message->load('user'),
            'session' => $session,
        ])->cookie('chat_session_token', $session->session_token, 60 * 24 * 365);
    }

    public function messages($sessionId)
    {
        $session = ChatSession::findOrFail($sessionId);

        // Verify ownership
        if (auth()->check() && $session->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $session->messages()->with('user')->get();

        return response()->json($messages);
    }
}

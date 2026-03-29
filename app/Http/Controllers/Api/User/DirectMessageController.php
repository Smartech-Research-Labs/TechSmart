<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\DirectMessage;
use App\Models\User;
use App\Models\UserPresence;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    /**
     * List conversations for the authenticated user.
     */
    public function conversations(Request $request)
    {
        $userId = auth()->id();

        $conversations = Conversation::forUser($userId)
            ->with(['userOne:id,name,email', 'userTwo:id,name,email', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($userId) {
                $q->where('receiver_id', $userId)->where('status', '!=', 'read');
            }])
            ->orderByDesc('last_message_at')
            ->paginate(20);

        // Enrich with presence data and partner info
        $presenceMap = UserPresence::whereIn('user_id', $conversations->pluck('user_one_id')->merge($conversations->pluck('user_two_id'))->unique())
            ->pluck('is_online', 'user_id')
            ->toArray();

        $items = $conversations->through(function ($conv) use ($userId, $presenceMap) {
            $partner = $conv->getOtherUser($userId);
            return [
                'id' => $conv->id,
                'partner' => $partner ? [
                    'id' => $partner->id,
                    'name' => $partner->name,
                    'email' => $partner->email,
                    'avatar' => $partner->profile_photo_url ?? null,
                    'is_online' => $presenceMap[$partner->id] ?? false,
                ] : null,
                'last_message' => $conv->latestMessage ? [
                    'body' => $conv->latestMessage->body,
                    'sender_id' => $conv->latestMessage->sender_id,
                    'status' => $conv->latestMessage->status,
                    'created_at' => $conv->latestMessage->created_at->toISOString(),
                ] : null,
                'unread_count' => $conv->unread_count,
                'last_message_at' => $conv->last_message_at?->toISOString(),
            ];
        });

        return response()->json($items);
    }

    /**
     * Get messages for a conversation.
     */
    public function messages(Request $request, Conversation $conversation)
    {
        $userId = auth()->id();

        // Ensure user is part of this conversation
        if ($conversation->user_one_id !== $userId && $conversation->user_two_id !== $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mark all received messages in this conversation as read
        DirectMessage::where('conversation_id', $conversation->id)
            ->where('receiver_id', $userId)
            ->where('status', '!=', 'read')
            ->update(['status' => 'read', 'read_at' => now()]);

        $messages = $conversation->messages()
            ->with('sender:id,name')
            ->orderByDesc('created_at')
            ->paginate(50);

        return response()->json($messages);
    }

    /**
     * Send a direct message to a user.
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string|max:5000',
        ]);

        $senderId = auth()->id();
        $receiverId = (int) $request->receiver_id;

        if ($senderId === $receiverId) {
            return response()->json(['error' => 'Cannot send message to yourself'], 422);
        }

        // Find or create the conversation
        $conversation = Conversation::between($senderId, $receiverId);

        // Check if receiver is online to set initial delivery status
        $receiverOnline = UserPresence::where('user_id', $receiverId)->value('is_online') ?? false;

        $message = DirectMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $request->body,
            'status' => $receiverOnline ? 'delivered' : 'sent',
            'delivered_at' => $receiverOnline ? now() : null,
        ]);

        $conversation->update(['last_message_at' => now()]);

        $message->load('sender:id,name');

        return response()->json([
            'message' => $message,
            'conversation_id' => $conversation->id,
        ], 201);
    }

    /**
     * Mark messages as read in a conversation.
     */
    public function markRead(Request $request, Conversation $conversation)
    {
        $userId = auth()->id();

        DirectMessage::where('conversation_id', $conversation->id)
            ->where('receiver_id', $userId)
            ->where('status', '!=', 'read')
            ->update(['status' => 'read', 'read_at' => now()]);

        return response()->json(['message' => 'Messages marked as read']);
    }

    /**
     * List online users for the chat.
     */
    public function onlineUsers()
    {
        $userId = auth()->id();

        $users = User::where('id', '!=', $userId)
            ->select('id', 'name', 'email')
            ->with(['presence' => function ($q) {
                $q->select('user_id', 'is_online', 'last_seen_at');
            }])
            ->limit(50)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_online' => $user->presence?->is_online ?? false,
                    'last_seen_at' => $user->presence?->last_seen_at?->toISOString(),
                ];
            })
            ->sortByDesc('is_online')
            ->values();

        return response()->json(['users' => $users]);
    }

    /**
     * Update current user's presence.
     */
    public function updatePresence(Request $request)
    {
        $request->validate([
            'is_online' => 'required|boolean',
        ]);

        UserPresence::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'is_online' => $request->is_online,
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['message' => 'Presence updated']);
    }
}

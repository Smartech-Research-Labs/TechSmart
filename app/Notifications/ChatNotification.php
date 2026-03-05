<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChatNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $senderName,
        public int $sessionId,
        public string $preview,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New chat message from {$this->senderName}",
            'item_type' => 'Chat',
            'item_name' => mb_substr($this->preview, 0, 80),
            'item_id' => $this->sessionId,
            'user_name' => $this->senderName,
        ];
    }
}

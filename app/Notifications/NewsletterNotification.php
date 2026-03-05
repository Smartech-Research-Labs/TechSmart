<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewsletterNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $email,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New newsletter subscriber: {$this->email}",
            'item_type' => 'Newsletter',
            'item_name' => $this->email,
            'item_id' => 0,
            'user_name' => $this->email,
        ];
    }
}

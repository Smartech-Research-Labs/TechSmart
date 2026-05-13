<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CookieConsentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $email,
        public array $preferences,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = "New cookie consent recorded";
        if ($this->preferences['marketing_cookies']) {
            $message .= " - Marketing cookies accepted";
        }
        if ($this->preferences['analytics_cookies']) {
            $message .= " - Analytics cookies accepted";
        }

        return [
            'message' => $message,
            'item_type' => 'Cookie Consent',
            'item_name' => $this->email ?: 'Anonymous',
            'item_id' => 0,
            'user_name' => $this->email ?: 'Visitor',
            'preferences' => $this->preferences,
        ];
    }
}

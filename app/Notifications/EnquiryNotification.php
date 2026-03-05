<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EnquiryNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $subject,
        public int $enquiryId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "New enquiry from {$this->senderName}: {$this->subject}",
            'item_type' => 'Enquiry',
            'item_name' => $this->subject,
            'item_id' => $this->enquiryId,
            'user_name' => $this->senderName,
            'email' => $this->senderEmail,
        ];
    }
}

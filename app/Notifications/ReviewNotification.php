<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReviewNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $reviewerName,
        public string $reviewableType,
        public string $reviewableName,
        public int $reviewId,
        public int $rating,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $stars = str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);

        return [
            'message' => "{$this->reviewerName} left a {$this->rating}-star review on {$this->reviewableName}",
            'item_type' => 'Review',
            'item_name' => "{$this->reviewableName} ({$stars})",
            'item_id' => $this->reviewId,
            'user_name' => $this->reviewerName,
            'rating' => $this->rating,
        ];
    }
}

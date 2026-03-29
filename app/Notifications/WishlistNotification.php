<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WishlistNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $userName,
        public string $itemType,
        public string $itemName,
        public int $itemId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $type = class_basename($this->itemType); // 'Product' or 'Service'

        return [
            'message' => "{$this->userName} added a {$type} to their wishlist",
            'item_type' => $type,
            'item_name' => $this->itemName,
            'item_id' => $this->itemId,
            'user_name' => $this->userName,
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification
{

    public function __construct(
        protected string $code
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Login Verification Code — OmniviaTech')
            ->greeting("Hello {$notifiable->name},")
            ->line('You are receiving this email because a login attempt was made on your account.')
            ->line("Your verification code is: **{$this->code}**")
            ->line('This code will expire in 10 minutes.')
            ->line('If you did not attempt to log in, please change your password immediately.')
            ->salutation('— OmniviaTech');
    }
}

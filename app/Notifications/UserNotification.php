<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    public ?string $url;

    public function __construct(string $title, string $message, ?string $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}

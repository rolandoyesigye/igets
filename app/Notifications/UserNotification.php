<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $title;
    public string $message;
    public ?string $url;

    public function __construct(
        string $title,
        string $message,
        ?string $url = null,
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    public function via($notifiable): array
    {
        // Always write to the database. Also send mail if the notifiable has an email address.
        $channels = ["database"];

        if (!empty($notifiable->email)) {
            $channels[] = "mail";
        }

        return $channels;
    }

    public function toDatabase($notifiable): array
    {
        return [
            "title" => $this->title,
            "message" => $this->message,
            "url" => $this->url,
        ];
    }

    /**
     * Build the mail representation of the notification.
     *
     * Admin users (or any notifiable with an email) will receive this email.
     */
    public function toMail($notifiable): MailMessage
    {
        $mail = new MailMessage()
            ->subject($this->title)
            ->greeting("Hello " . ($notifiable->name ?? "Admin") . ",")
            ->line($this->message);

        if (!empty($this->url)) {
            $mail->action("View Details", $this->url);
        }

        $mail->line("Thank you for using our application.");

        return $mail;
    }
}

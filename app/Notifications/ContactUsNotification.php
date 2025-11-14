<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactUsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Us Message - ' . $this->name)
            ->line('You have received a new message from the Contact Us form.')
            ->line('Name: ' . $this->name)
            ->line('Email: ' . $this->email)
            ->line('Message: ' . substr($this->message, 0, 200) . '...')
            ->action('View Dashboard', route('admin.dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'contact_us',
            'message' => 'New contact message from ' . $this->name . ' (' . $this->email . ')',
            'name' => $this->name,
            'email' => $this->email,
            'message_text' => $this->message,
            'route_url' => route('admin.dashboard'),
        ];
    }
}


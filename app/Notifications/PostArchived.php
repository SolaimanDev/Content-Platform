<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostArchived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $post) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Post Has Been Archived')
            ->line("Your post '{$this->post->title}' has been automatically archived.")
            ->line('Reason: Not reviewed within 3 days.')
            ->action('View Post', url("/posts/{$this->post->id}"));
    }
}

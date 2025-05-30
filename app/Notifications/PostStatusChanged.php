<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $status;

    public function __construct($post, $status)
    {
        $this->post = $post;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusText = $this->status == 1 ? 'Active' : 'Inactive';
        
        return (new MailMessage)
            ->subject("Your Post Status Changed to {$statusText}")
            ->line("Your post '{$this->post->title}' status has been changed to {$statusText}.")
            ->action('View Post', url('/admin/posts/'.$this->post->id))
            ->line('Thank you for using our application!');
    }
}
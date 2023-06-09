<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use \App\Models\User;

class NewFollow extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $follower, User $followee)
    {
        $this->follower = $follower;
        $this->followee = $followee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("@" . $this->follower->username . " started following you!")
                    ->action('Go to @' . $this->follower->username . "'s profile", route('profile', $this->follower->id))
                    ->line("Thank you for using Tuitter!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->follower->id,
        ];
    }
}

<?php

namespace App\Notifications;

use App\Models\Bottle;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class BottleWasUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bottle)
    {
        $this->bottle = $bottle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // https://laracasts.com/series/laravel-6-from-scratch/episodes/48
        // return $notifiable->prefers_sms ? ['nexmo'] : ['mail', 'database'];
        // return ['mail', 'database', 'slack', 'nexmo'];
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A bottle you follow just updated it\'s rating!')
            ->action('Got to Bottle on Wine Window', url('/'))
            ->line('Thank you for using Wine Window!');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content('A bottle you follow was just updated!');
    }

    /**
     * Get the Vonage / SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('A bottle you follow was just updated!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'A bottle you follow was just updated!'
        ];
    }
}

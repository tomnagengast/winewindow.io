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

class BottleWasUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $bottle;

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
        return ['database', 'slack', 'mail'];
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
            ->action('View to Bottle on Wine Window', url('/bottles/'.$this->bottle->id))
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
            ->content($notifiable->name.', a bottle you follow was just updated! See '.$this->bottle->varietal);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        info('Notifying user that bottle was updated');
        return [
            'message' => $this->name.', a bottle you follow was just updated! '.$this->bottle->varietal
        ];
    }
}

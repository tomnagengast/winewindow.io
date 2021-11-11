<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioChannel
{
    /**
     * Send the given notification.e
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$notifiable->phone) {
            info('TwilioChannel called but User has not provided their phone number.');
            return;
        }

        $message = $notification->toTwilio($notifiable);

        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');

        // TODO extract to config/services.php
        $from = "+18052571551";
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($notifiable->phone, [
                'from' => $from,
                'body' => $message
            ]
        );
    }
}

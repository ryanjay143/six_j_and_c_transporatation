<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toTwilio($notifiable);

        $twilioClient = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $twilioClient->messages->create(
            $notifiable->phone_num,
            [
                'from' => config('services.twilio.phone_number'),
                'body' => $message,
            ]
        );
    }
}

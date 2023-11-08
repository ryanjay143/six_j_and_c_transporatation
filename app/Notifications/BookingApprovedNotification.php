<?php 

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\TwilioMessage;

class BookingApprovedNotification extends Notification
{
    public function via($notifiable)
    {
        return ['twilio'];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioMessage())
            ->content('Your booking has been approved. Thank you!');
    }
}

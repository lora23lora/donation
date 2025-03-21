<?php

namespace App\Notifications;

use Laravel\Nova\Notifications\NovaNotification;
use Illuminate\Notifications\Notification;

class DonationNotification extends Notification
{
    protected $donation;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New donation added!',
            'redirect_url' => url('/resources/donations/' . $this->donation->id),
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New donation added!',
            'redirect_url' => url('/resources/donations/' . $this->donation->id),
        ];
    }

    public function toNova($notifiable)
    {
        return NovaNotification::make()
            ->message('New donation added!')
            ->url('/resources/donations/' . $this->donation->id)
            ->type('info');
    }
}

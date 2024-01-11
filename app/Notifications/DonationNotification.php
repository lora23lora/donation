<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationNotification extends Notification
{
    protected $donation;
    protected $redirectUrl;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    public function withRedirectUrl($url)
    {
        $this->redirectUrl = $url;
        return $this;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'donation_id' => $this->donation->id,
            'message' => 'Name: ' . $this->donation->name . ' Status: ' . $this->donation->status,
            'redirect_url' => $this->redirectUrl,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'donation_id' => $this->donation->id,
            'message' => 'Name: ' . $this->donation->name . ' Status: ' . $this->donation->status,
            'redirect_url' => $this->redirectUrl,
        ];
    }

    public function viaQueues($notifiable)
    {
        return ['database'];
    }

    public function toNova($notifiable)
    {
        return [
            'donation_id' => $this->donation->id,
            'message' => 'Name: ' . $this->donation->name . ' Status: ' . $this->donation->status,
            'redirect_url' => $this->redirectUrl,
        ];
    }
}

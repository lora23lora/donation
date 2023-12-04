<?php

namespace App\Observers;

use App\Models\Donation;
use App\Models\User;
use App\Notifications\DonationNotification;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\Nova;

class DonationObserver
{
    /**
     * Handle the Donation "created" event.
     */
    public function created(Donation $donation): void
    {

        foreach (User::all() as $u) {
            $resourceId = $donation->id;

            $baseUrl = '/resources/donations/'; // Change this to your base URL for Donation resource view

            $notification = NovaNotification::make()
                ->message('Name: ' . $donation->name . ' | Status: ' . $donation->status->name)
                ->url($baseUrl . $resourceId)
                ->type('info');

            $u->notify($notification);
        }
    }

    /**
     * Handle the Donation "updated" event.
     */
    public function updated(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "deleted" event.
     */
    public function deleted(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "restored" event.
     */
    public function restored(Donation $donation): void
    {
        //
    }

    /**
     * Handle the Donation "force deleted" event.
     */
    public function forceDeleted(Donation $donation): void
    {
        //
    }
}

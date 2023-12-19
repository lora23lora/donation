<?php

namespace App\Observers;

use App\Models\Donation;
use App\Models\Storage;
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

        $this->updateStorageFromLineItems($donation->line_items, true);

        $adminUsers = User::where('name', 'admin')->get();

        foreach ($adminUsers as $admin) {
            $resourceId = $donation->id;

            $baseUrl = '/resources/donations/'; // Change this to your base URL for Donation resource view

            $notification = NovaNotification::make()
                ->message('Name: ' . $donation->name . ' | Status: ' . $donation->status->name)
                ->url($baseUrl . $resourceId)
                ->type('info');

            $admin->notify($notification);
        }

    }


    private function updateStorageFromLineItems($lineItems, $subtract)
    {
        foreach ($lineItems as $item) {
            $itemId = $item['attributes']['items']; // Assuming 'items' represents item_id in Storage table
            $qty = $item['attributes']['qty'];
            $price = $item['attributes']['price'];

            $storageItem = Storage::find($itemId);

            if ($storageItem) {
                $qtyToSubtract = $subtract ? $qty : -$qty;
                $priceToSubtract = $subtract ? $price : -$price;

                $storageItem->qty -= $qtyToSubtract;
                $storageItem->price -= $priceToSubtract;
                $storageItem->save();
            }
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

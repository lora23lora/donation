<?php

namespace App\Observers;

use App\Models\Donation;
use App\Models\Storage;
use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;

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

            $baseUrl = '/resources/donations/';

            $notification = NovaNotification::make()
                ->message('Name: ' . $donation->name . ' | Status: ' . $donation->status)
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

            $storageItem = Storage::find($itemId);

            if ($storageItem) {
                $qtyToSubtract = $subtract ? $qty : -$qty;

                $storageItem->qty -= $qtyToSubtract;
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

}

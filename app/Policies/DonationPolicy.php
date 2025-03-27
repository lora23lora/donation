<?php

namespace App\Policies;

use App\Models\Donation;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any donations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // Return false to deny access to viewing any donations
        return true;
    }

    /**
     * Determine whether the user can view the donation.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user)
    {

        if (strpos(url()->current(), 'lens') !== false) {
            return false; // Deny access
        }

        return true;
    }

    /**
     * Determine whether the user can create donations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the donation.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user)
    {
        if (strpos(url()->current(), 'lens') !== false) {
            return false; // Deny access
        }

        return true;
    }
    public function attachAnyStorage(User $user, Donation $donation)
    {
        return true; // Allow attaching new storage items
    }

    public function attachStorage(User $user, Donation $donation, Storage $storage)
    {
        // If the item is already attached, disable "edit" button
        if ($donation->storages->contains('item_id', $storage->item_id)) {
            return false;
        }

        // Otherwise, allow attaching
        return $this->attachAnyStorage($user, $donation);
    }

    public function detachStorage(User $user, Donation $donation, Storage $storage)
    {
        return true; // Allow detaching storage items if needed
    }


    /**
     * Determine whether the user can delete the donation.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        if (strpos(url()->current(), 'lens') !== false) {
            return false; // Deny access
        }

        return true;
    }
}

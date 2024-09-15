<?php

namespace App\Policies;

use App\Models\User;

class Storage_DonationPolicy
{
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

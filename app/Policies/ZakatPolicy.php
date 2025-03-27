<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Zakat;
use App\Models\User;

class ZakatPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Zakat $zakat)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Zakat $zakat)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Zakat $zakat)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Zakat $zakat)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Zakat $zakat)
    {
        //
    }
}

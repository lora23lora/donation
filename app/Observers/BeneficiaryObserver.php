<?php

namespace App\Observers;

use App\Models\Beneficiary;
use Illuminate\Validation\ValidationException;

class BeneficiaryObserver
{
    /**
     * Handle the Beneficiary "created" event.
     */
    public function creating(Beneficiary $beneficiary)
    {
        $statusArray = is_array($beneficiary->status) ? $beneficiary->status : json_decode($beneficiary->status);

        if (!is_array($statusArray) || count($statusArray) === 0) {
            throw ValidationException::withMessages([
                'status' => __('at least one status is required'),
            ]);
        }
    }
}

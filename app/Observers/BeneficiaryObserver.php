<?php

namespace App\Observers;

use App\Models\Beneficiary;
use Illuminate\Validation\ValidationException;

class BeneficiaryObserver
{
    /**
     * Handle the Beneficiary "created" event.
     */
    public function saving(Beneficiary $beneficiary)
    {
        // Convert the status attribute to an array if it's not already
        $statusArray = is_array($beneficiary->status) ? $beneficiary->status : json_decode($beneficiary->status);

        // Validate that at least one status is selected
        if (!is_array($statusArray) || count($statusArray) === 0) {
            throw ValidationException::withMessages([
                'status' => __('At least one status is required.'),
            ]);
        }

        // Convert the status attribute back to JSON before saving
        $beneficiary->status = json_encode($statusArray);
    }

}

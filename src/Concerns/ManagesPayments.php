<?php

namespace LaravelPayHere\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;
use LaravelPayHere\Models\Payment;

trait ManagesPayments
{
    /**
     * Sets up a one-to-one relationship with the Payment model.
     */
    public function payments(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}

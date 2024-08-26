<?php

namespace LaravelPayHere\Concerns;

use LaravelPayHere\Models\Payment;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

<?php

declare(strict_types=1);

namespace PayHere\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;
use PayHere\Models\Payment;

trait ManagesPayments
{
    /**
     * Sets up a one-to-one relationship with the Payment model.
     */
    public function payments(): HasOne
    {
        return $this->hasOne(Payment::class)->orderByDesc('created_at');
    }
}

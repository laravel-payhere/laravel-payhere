<?php

namespace LaravelPayHere\Models\Concerns;

use LaravelPayHere\Services\Contracts\PayHereService;

/**
 * @property $payment
 */
trait HasRefund
{
    /**
     * Initiate a refund for the order.
     */
    public function refund(?string $reason = null): bool
    {
        return app(PayHereService::class)->refundPayment($this->payment->id, $reason);
    }
}

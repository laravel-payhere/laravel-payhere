<?php

namespace Dasundev\PayHere\Models\Concerns;

use Dasundev\PayHere\Services\Contracts\PayHereService;

/**
 * @property $payment
 */
class HasRefund
{
    /**
     * Initiate a refund for the order.
     */
    public function refund(?string $reason = null): bool
    {
        return app(PayHereService::class)->refund($this->payment->id, $reason);
    }
}

<?php

declare(strict_types=1);

namespace PayHere\Models\Concerns;

use PayHere\Services\Contracts\PayHereService;

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

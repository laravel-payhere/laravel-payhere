<?php

declare(strict_types=1);

namespace PayHere\Services\Contracts;

use PayHere\Models\Payment;
use PayHere\Models\Subscription;

interface PayHereService
{
    public function refundPayment(Payment $payment, ?string $reason = null): array;

    public function cancelSubscription(Subscription $subscription): array;

    public function retrySubscription(Subscription $subscription): array;
}

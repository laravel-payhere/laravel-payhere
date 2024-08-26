<?php

declare(strict_types=1);

namespace LaravelPayHere\Services\Contracts;

use LaravelPayHere\Models\Payment;
use LaravelPayHere\Models\Subscription;

interface PayHereService
{
    public function refundPayment(Payment $payment, ?string $reason = null): array;

    public function cancelSubscription(Subscription $subscription): array;

    public function retrySubscription(Subscription $subscription): array;
}

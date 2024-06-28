<?php

namespace Dasundev\PayHere\Services\Contracts;

use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;

interface PayHereService
{
    public function refund(Payment $payment, ?string $reason = null): array;

    public function cancelSubscription(Subscription $subscription): array;
}

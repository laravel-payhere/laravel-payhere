<?php

namespace Dasundev\PayHere\Services\Contracts;

use Dasundev\PayHere\Models\Payment;

interface PayHereService
{
    public function refund(Payment $payment, ?string $reason = null): array;
}

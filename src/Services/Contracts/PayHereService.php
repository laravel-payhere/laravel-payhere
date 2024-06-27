<?php

namespace Dasundev\PayHere\Services\Contracts;

interface PayHereService
{
    public function refund(string $paymentId, ?string $reason = null): array;
}
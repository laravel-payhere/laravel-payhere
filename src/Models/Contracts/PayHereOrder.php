<?php

namespace Dasundev\PayHere\Models\Contracts;

interface PayHereOrder
{
    /**
     * Get the unique identifier of the order.
     */
    public function payHereOrderId(): string;
}
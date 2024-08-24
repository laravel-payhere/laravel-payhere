<?php

namespace LaravelPayHere\Models\Contracts;

interface PayHereOrderLine
{
    /**
     * Get the unique identifier of the order line.
     */
    public function payHereOrderLineId(): string;

    /**
     * Get the title of the order line.
     */
    public function payHereOrderLineTitle(): string;

    /**
     * Get the quantity of the order line.
     */
    public function payHereOrderLineQty(): int;

    /**
     * Get the total amount for the order line.
     */
    public function payHereOrderLineTotal(): float;

    /**
     * Get the unit amount for the order line.
     */
    public function payHereOrderLineUnitPrice(): float;
}

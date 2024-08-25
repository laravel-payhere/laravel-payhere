<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelPayHere\Models\Contracts\PayHereOrderLine;

class OrderLine extends Model implements PayHereOrderLine
{
    protected $guarded = [];

    public function payHereOrderLineId(): string
    {
        // TODO: Implement payHereOrderLineId() method.
    }

    public function payHereOrderLineTitle(): string
    {
        // TODO: Implement payHereOrderLineTitle() method.
    }

    public function payHereOrderLineQty(): int
    {
        // TODO: Implement payHereOrderLineQty() method.
    }

    public function payHereOrderLineTotal(): float
    {
        // TODO: Implement payHereOrderLineTotal() method.
    }

    public function payHereOrderLineUnitPrice(): float
    {
        // TODO: Implement payHereOrderLineUnitPrice() method.
    }
}

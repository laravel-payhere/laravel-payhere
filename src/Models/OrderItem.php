<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LaravelPayHere\Database\Factories\OrderFactory;
use LaravelPayHere\Database\Factories\OrderItemFactory;
use LaravelPayHere\Models\Contracts\PayHereOrderLine;

class OrderItem extends Model implements PayHereOrderLine
{
    protected $guarded = [];

    protected $table = 'order_items';

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }

    public function payHereOrderLineId(): string
    {
        return $this->id;
    }

    public function payHereOrderLineTitle(): string
    {
        return $this->purchasable->title;
    }

    public function payHereOrderLineQty(): int
    {
        return $this->unit_quantity;
    }

    public function payHereOrderLineTotal(): float
    {
        return $this->total;
    }

    public function payHereOrderLineUnitPrice(): float
    {
        return $this->unit_price;
    }

    public static function factory(): OrderItemFactory
    {
        return new OrderItemFactory;
    }
}

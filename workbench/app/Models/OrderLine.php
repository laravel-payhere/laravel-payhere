<?php

namespace Workbench\App\Models;

use LaravelPayHere\Models\Contracts\PayHereOrderLine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Workbench\Database\Factories\OrderLineFactory;

class OrderLine extends Model implements PayHereOrderLine
{
    use HasFactory;

    protected $guarded = [];

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

    protected static function newFactory(): OrderLineFactory
    {
        return new OrderLineFactory;
    }
}

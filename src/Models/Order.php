<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelPayHere\Models\Contracts\PayHereOrder;
use LaravelPayHere\PayHere;

class Order extends Model implements PayHereOrder
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    public function payHereOrderId(): string
    {
        return $this->id;
    }

    public function payHereOrderTotal(): float
    {
        return $this->total;
    }
}

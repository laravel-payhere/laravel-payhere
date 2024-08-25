<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use LaravelPayHere\Database\Factories\OrderFactory;
use LaravelPayHere\Models\Contracts\PayHereOrder;
use LaravelPayHere\PayHere;

class Order extends Model implements PayHereOrder
{
    protected $guarded = [];

    protected $table = 'orders';

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function payHereOrderId(): string
    {
        return $this->id;
    }

    public function payHereOrderTotal(): float
    {
        return $this->total;
    }

    public static function factory(): OrderFactory
    {
        return new OrderFactory;
    }
}

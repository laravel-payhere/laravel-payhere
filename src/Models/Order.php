<?php

namespace LaravelPayHere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use LaravelPayHere\Models\Contracts\PayHereOrder;
use LaravelPayHere\PayHere;

class Order extends Model implements PayHereOrder
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
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

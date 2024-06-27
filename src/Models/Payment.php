<?php

namespace Dasundev\PayHere\Models;

use Dasundev\PayHere\Enums\MessageType;
use Dasundev\PayHere\Enums\PaymentMethod;
use Dasundev\PayHere\Enums\PaymentStatus;
use Dasundev\PayHere\PayHere;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\Database\Factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'method' => PaymentMethod::class,
        'status_code' => PaymentStatus::class,
        'message_type' => MessageType::class,
    ];

    protected $hidden = [
        'md5sig',
        'authorization_token',
        'customer_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(PayHere::$orderModel);
    }

    public function markAsRefunded(): bool
    {
        return $this->update(['refunded' => true]);
    }

    public function scopeRefunded(Builder $query): void
    {
        $query->where('refunded');
    }

    public function scopeNotRefunded(Builder $query): void
    {
        $query->whereNot('refunded');
    }

    protected static function newFactory(): PaymentFactory
    {
        return new PaymentFactory;
    }
}

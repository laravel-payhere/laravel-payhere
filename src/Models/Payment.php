<?php

namespace LaravelPayHere\Models;

use LaravelPayHere\Enums\MessageType;
use LaravelPayHere\Enums\PaymentMethod;
use LaravelPayHere\Enums\PaymentStatus;
use LaravelPayHere\PayHere;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\Database\Factories\PaymentFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payhere_payments';

    protected $guarded = [];

    protected $casts = [
        'method' => PaymentMethod::class,
        'status_code' => PaymentStatus::class,
        'message_type' => MessageType::class,
        'refunded' => 'boolean',
        'payment_id' => 'encrypted',
        'subscription_id' => 'encrypted',
        'md5sig' => 'encrypted',
        'authorization_token' => 'encrypted',
        'customer_token' => 'encrypted',
        'card_holder_name' => 'encrypted',
        'card_expiry' => 'encrypted',
        'card_no' => 'encrypted',
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

    public function markAsRefunded(?string $reason = null): bool
    {
        return $this->update([
            'refunded' => true,
            'refund_reason' => $reason,
        ]);
    }

    public function isRefundable(): bool
    {
        return ! is_null($this->payment_id) && $this->refunded === false;
    }

    public function scopeRefunded(Builder $query): void
    {
        $query->where('refunded', true);
    }

    public function scopeNotRefunded(Builder $query): void
    {
        $query->where('refunded', false);
    }

    protected static function newFactory(): PaymentFactory
    {
        return new PaymentFactory;
    }
}

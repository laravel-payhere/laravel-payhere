<?php

declare(strict_types=1);

namespace PayHere\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PayHere\Enums\MessageType;
use PayHere\Enums\PaymentMethod;
use PayHere\Enums\PaymentStatus;
use PayHere\Events\PaymentRefunded;
use PayHere\PayHere;
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

    public function markAsRefunded(?string $reason = null): void
    {
        $this->update(['refunded' => true, 'refund_reason' => $reason]);

        PaymentRefunded::dispatch($this);
    }

    public function isRefundable(): bool
    {
        return ! is_null($this->payhere_payment_id) && $this->refunded === false;
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

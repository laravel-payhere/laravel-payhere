<?php

namespace LaravelPayHere\Models;

use LaravelPayHere\Enums\SubscriptionStatus;
use LaravelPayHere\Models\Concerns\ManagesSubscriptions;
use LaravelPayHere\PayHere;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workbench\Database\Factories\SubscriptionFactory;

class Subscription extends Model
{
    use HasFactory;
    use ManagesSubscriptions;

    protected $guarded = [];

    protected $casts = [
        'payhere_subscription_id' => 'encrypted',
        'status' => SubscriptionStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(PayHere::$orderModel);
    }

    /**
     * Determine if the subscription is within its trial period.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Filter query by on trial.
     */
    public function scopeOnTrial(Builder $query): void
    {
        $query->whereNotNull('trial_ends_at')->where('trial_ends_at', '>', now());
    }

    /**
     * Filter active subscriptions.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', SubscriptionStatus::Active);
    }

    public function isFailed(): bool
    {
        return $this->status === SubscriptionStatus::Failed;
    }

    public function isCancellable(): bool
    {
        return ! is_null($this->payhere_subscription_id) && $this->status === SubscriptionStatus::Active;
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => SubscriptionStatus::Cancelled]);
    }

    public function markAsActive(): void
    {
        $this->update(['status' => SubscriptionStatus::Active]);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => SubscriptionStatus::Completed]);
    }

    protected static function newFactory(): SubscriptionFactory
    {
        return new SubscriptionFactory;
    }
}

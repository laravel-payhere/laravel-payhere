<?php

declare(strict_types=1);

namespace PayHere\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PayHere\Enums\SubscriptionStatus;
use PayHere\Events\SubscriptionCancelled;
use PayHere\Events\SubscriptionRetrySucceeded;
use PayHere\Models\Concerns\ManagesSubscriptions;
use PayHere\PayHere;
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

        SubscriptionCancelled::dispatch($this);
    }

    public function markAsActive(): void
    {
        $this->update(['status' => SubscriptionStatus::Active]);

        SubscriptionRetrySucceeded::dispatch($this);
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

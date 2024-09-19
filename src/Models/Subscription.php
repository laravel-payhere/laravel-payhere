<?php

declare(strict_types=1);

namespace PayHere\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PayHere\Enums\SubscriptionStatus;
use PayHere\Events\SubscriptionActivated;
use PayHere\Events\SubscriptionCancelled;
use PayHere\Events\SubscriptionCompleted;
use PayHere\PayHere;
use Workbench\Database\Factories\SubscriptionFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => SubscriptionStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(PayHere::$customerModel);
    }

    /**
     * Determine if the subscription is within its trial period.
     *
     * @return bool
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Filter query by on trial.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeOnTrial(Builder $query): void
    {
        $query->whereNotNull('trial_ends_at')->where('trial_ends_at', '>', now());
    }

    /**
     * Filter active subscriptions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', SubscriptionStatus::Active);
    }

    /**
     * Determine if the subscription has failed.
     *
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status === SubscriptionStatus::Failed;
    }

    /**
     * Check if the subscription is eligible for cancellation.
     *
     * @return bool
     */
    public function isCancellable(): bool
    {
        return ! is_null($this->payhere_subscription_id) && $this->status === SubscriptionStatus::Active;
    }

    /**
     * Mark the subscription as cancelled.
     *
     * @return void
     */
    public function markAsCancelled(): void
    {
        $this->update(['status' => SubscriptionStatus::Cancelled]);

        SubscriptionCancelled::dispatch($this);
    }

    /**
     * Mark the subscription as active.
     *
     * @return void
     */
    public function markAsActive(): void
    {
        $this->status = SubscriptionStatus::Active;

        // Dispatch the event only if the status has changed
        SubscriptionActivated::dispatchIf($this->isDirty('status'), $this);

        $this->save();
    }

    /**
     * Mark the subscription as completed.
     *
     * @return void
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => SubscriptionStatus::Completed]);

        SubscriptionCompleted::dispatch($this);
    }

    protected static function newFactory(): SubscriptionFactory
    {
        return new SubscriptionFactory;
    }
}

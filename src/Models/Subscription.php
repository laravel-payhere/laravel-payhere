<?php

namespace Dasundev\PayHere\Models;

use Carbon\Carbon;
use Dasundev\PayHere\Enums\SubscriptionStatus;
use Dasundev\PayHere\PayHere;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(PayHere::$orderModel);
    }

    protected static function newFactory(): SubscriptionFactory
    {
        return new SubscriptionFactory;
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
}

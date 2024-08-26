<?php

namespace LaravelPayHere\Events;

use LaravelPayHere\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRetrySucceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Subscription $subscription
    ) {}
}

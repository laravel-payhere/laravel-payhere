<?php

declare(strict_types=1);

namespace PayHere\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PayHere\Models\Subscription;

class SubscriptionCancelled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Subscription $subscription
    ) {}
}

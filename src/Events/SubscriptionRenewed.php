<?php

namespace Dasundev\PayHere\Events;

use Dasundev\PayHere\Models\Subscription;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Subscription $subscription
    ) {}
}

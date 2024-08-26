<?php

namespace LaravelPayHere\Events;

use LaravelPayHere\Models\Payment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentRefunded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Payment $payment
    ) {}
}

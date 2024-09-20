<?php

declare(strict_types=1);

namespace PayHere\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PayHere\Models\Payment;

class PaymentRefunded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Payment $payment
    ) {}
}

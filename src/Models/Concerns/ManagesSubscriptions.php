<?php

declare(strict_types=1);

namespace PayHere\Models\Concerns;

use PayHere\Services\Contracts\PayHereService;

trait ManagesSubscriptions
{
    public function cancel()
    {
        return app(PayHereService::class)->cancelSubscription($this);
    }

    public function retry()
    {
        return app(PayHereService::class)->retrySubscription($this);
    }
}

<?php

namespace LaravelPayHere\Models\Concerns;

use LaravelPayHere\Services\Contracts\PayHereService;

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

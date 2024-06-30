<?php

namespace Dasundev\PayHere\Models\Concerns;

use Dasundev\PayHere\Services\Contracts\PayHereService;

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

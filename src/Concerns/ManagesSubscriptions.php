<?php

declare(strict_types=1);

namespace PayHere\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use PayHere\Models\Subscription;
use PayHere\PayHere;

trait ManagesSubscriptions
{
    public function subscriptions(): HasMany
    {
        return $this->hasMany(PayHere::$subscriptionModel);
    }
}

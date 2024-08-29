<?php

declare(strict_types=1);

namespace PayHere\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use PayHere\PayHere;

trait ManagesSubscriptions
{
    /**
     * Sets up a one-to-many relationship with the Subscription model.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(PayHere::$subscriptionModel)->orderByDesc('created_at');
    }
}

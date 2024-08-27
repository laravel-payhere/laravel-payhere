<?php

namespace LaravelPayHere\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelPayHere\Models\Subscription;

trait ManagesSubscriptions
{
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
<?php

declare(strict_types=1);

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

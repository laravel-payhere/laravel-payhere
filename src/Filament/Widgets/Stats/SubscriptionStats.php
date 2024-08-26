<?php

namespace LaravelPayHere\Filament\Widgets\Stats;

use LaravelPayHere\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Subscription::active();
    }
}

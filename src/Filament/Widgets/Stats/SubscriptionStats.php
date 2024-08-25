<?php

namespace LaravelPayHere\Filament\Widgets\Stats;

use Illuminate\Database\Eloquent\Builder;
use LaravelPayHere\Models\Subscription;

class SubscriptionStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Subscription::active();
    }
}

<?php

namespace Dasundev\PayHere\Filament\Widgets\Stats;

use Dasundev\PayHere\Models\Subscription;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Subscription::query();
    }
}

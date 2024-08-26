<?php

namespace LaravelPayHere\Filament\Widgets\Stats;

use Illuminate\Database\Eloquent\Builder;
use LaravelPayHere\Models\Payment;

class RefundStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Payment::refunded();
    }
}

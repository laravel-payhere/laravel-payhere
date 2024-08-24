<?php

namespace LaravelPayHere\Filament\Widgets\Stats;

use LaravelPayHere\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class RefundStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Payment::refunded();
    }
}

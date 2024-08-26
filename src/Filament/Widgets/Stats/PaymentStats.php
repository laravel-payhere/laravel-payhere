<?php

namespace LaravelPayHere\Filament\Widgets\Stats;

use LaravelPayHere\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class PaymentStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Payment::query();
    }
}

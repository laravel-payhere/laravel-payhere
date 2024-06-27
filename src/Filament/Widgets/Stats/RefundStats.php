<?php

namespace Dasundev\PayHere\Filament\Widgets\Stats;

use Dasundev\PayHere\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class RefundStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Payment::refunded();
    }
}

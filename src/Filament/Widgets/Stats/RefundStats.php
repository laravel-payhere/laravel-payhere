<?php

declare(strict_types=1);

namespace PayHere\Filament\Widgets\Stats;

use Illuminate\Database\Eloquent\Builder;
use PayHere\Models\Payment;

class RefundStats extends BaseStats
{
    protected static function getQuery(): Builder
    {
        return Payment::refunded();
    }
}

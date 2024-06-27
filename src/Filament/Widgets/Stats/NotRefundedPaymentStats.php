<?php

namespace Dasundev\PayHere\Filament\Widgets\Stats;

use Dasundev\PayHere\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class NotRefundedPaymentStats extends BaseStats
{
    protected static ?string $model = Payment::class;

    protected static function getQuery(): Builder
    {
        return Payment::notRefunded();
    }
}

<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total payments', '192.1k'),
            Stat::make('Refund payments', '21%'),
            Stat::make('Profit', '3:12'),
        ];
    }
}

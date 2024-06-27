<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Dasundev\PayHere\Filament\Widgets\Stats\PaymentStats;
use Dasundev\PayHere\Filament\Widgets\Stats\RefundStats;
use Dasundev\PayHere\Filament\Widgets\Stats\SubscriptionStats;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            $this->makeStat('Payments', PaymentStats::class),
            $this->makeStat('Subscriptions', SubscriptionStats::class),
            $this->makeStat('Refunds', RefundStats::class),
        ];
    }

    protected function makeStat(string $label, string $statsClass): Stat
    {
        $stats = $statsClass::getStats();

        return Stat::make($label, $stats['count'])
            ->description($stats['description'])
            ->chart($stats['chartData'])
            ->descriptionIcon($stats['icon'])
            ->color($stats['color']);
    }
}

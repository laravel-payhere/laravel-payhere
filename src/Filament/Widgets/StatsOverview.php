<?php

namespace LaravelPayHere\Filament\Widgets;

use LaravelPayHere\Filament\Widgets\Stats\PaymentStats;
use LaravelPayHere\Filament\Widgets\Stats\RefundStats;
use LaravelPayHere\Filament\Widgets\Stats\SubscriptionStats;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected static bool $isLazy = false;

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

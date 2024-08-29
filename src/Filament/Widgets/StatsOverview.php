<?php

declare(strict_types=1);

namespace PayHere\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use PayHere\Filament\Widgets\Stats\PaymentStats;
use PayHere\Filament\Widgets\Stats\RefundStats;
use PayHere\Filament\Widgets\Stats\SubscriptionStats;

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

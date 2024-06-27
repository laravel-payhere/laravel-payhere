<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Dasundev\PayHere\Filament\Widgets\Stats\NotRefundedPaymentStats;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $paymentStats = NotRefundedPaymentStats::getStats();

        return [
            Stat::make('Payments', $paymentStats['count'])
                ->description($paymentStats['description'])
                ->chart($paymentStats['chartData'])
                ->descriptionIcon($paymentStats['icon'])
                ->color($paymentStats['color']),
            Stat::make('Subscriptions', Subscription::count())
                ->description('10k increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Refunds', Payment::refunded()->count())
                ->description('10k increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
        ];
    }
}

<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;
use Dasundev\PayHere\Repositories\PaymentRepository;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $paymentStats = app(PaymentRepository::class)->getNotRefundedPaymentStats();

        return [
            Stat::make('Payments', Payment::notRefunded()->count())
                ->description($paymentStats['description'])
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
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

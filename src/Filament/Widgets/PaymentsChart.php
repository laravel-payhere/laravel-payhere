<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PaymentsChart extends ChartWidget
{
    protected static ?string $heading = 'Payments';

    protected static ?int $sort = 2;

    public ?string $filter = 'today';

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Subscriptions',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public function getDescription(): ?string
    {
        return "The total number of payments for $this->filter.";
    }

    protected function getType(): string
    {
        return 'line';
    }
}
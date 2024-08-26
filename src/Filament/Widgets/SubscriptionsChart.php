<?php

namespace LaravelPayHere\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use LaravelPayHere\Models\Subscription;

class SubscriptionsChart extends ChartWidget
{
    protected static ?string $heading = 'Subscriptions';

    protected static ?int $sort = 2;

    public ?string $filter = 'month';

    protected static ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $data = Trend::model(Subscription::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->interval($this->filter)
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
        return "The total number of subscriptions for $this->filter.";
    }

    protected function getFilters(): ?array
    {
        return [
            'day' => 'Daily',
            'month' => 'Monthly',
            'year' => 'Yearly',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

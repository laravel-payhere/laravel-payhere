<?php

declare(strict_types=1);

namespace PayHere\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use PayHere\Models\Payment;

class PaymentsChart extends ChartWidget
{
    protected static ?string $heading = 'Payments';

    protected static ?int $sort = 2;

    public ?string $filter = 'month';

    protected static ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $data = Trend::model(Payment::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->interval($this->filter)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Payments',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    public function getDescription(): ?string
    {
        return "The total number of payments per $this->filter.";
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

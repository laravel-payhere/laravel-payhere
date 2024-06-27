<?php

namespace Dasundev\PayHere\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PaymentsChart extends ChartWidget
{
    protected static ?string $heading = 'Payments';

    protected static ?int $sort = 2;

    public ?string $filter = 'today';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Payments created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    public function getDescription(): ?string
    {
        return "The number of payments for $this->filter.";
    }

    protected function getType(): string
    {
        return 'line';
    }
}
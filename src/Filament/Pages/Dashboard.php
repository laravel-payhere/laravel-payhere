<?php

declare(strict_types=1);

namespace PayHere\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Overview';

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
}

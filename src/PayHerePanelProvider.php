<?php

namespace Dasundev\PayHere;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages;

class PayHerePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('payhere')
            ->path('payhere')
            ->brandName('Laravel PayHere')
            ->pages([
                Pages\Dashboard::class,
            ]);
    }
}
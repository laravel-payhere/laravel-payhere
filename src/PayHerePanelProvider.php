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
            ->brandLogo(asset('vendor/payhere/images/logo.png'))
            ->brandLogoHeight('3rem')
            ->pages([
                Pages\Dashboard::class,
            ]);
    }
}
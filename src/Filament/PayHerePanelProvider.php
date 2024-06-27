<?php

namespace Dasundev\PayHere\Filament;

use Dasundev\PayHere\Filament\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PayHerePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('payhere')
            ->path('payhere')
            ->spa()
            ->brandLogo(asset('vendor/payhere/images/logo.png'))
            ->brandLogoHeight('3rem')
            ->darkMode()
            ->login()
            ->topNavigation()
            ->navigationItems([
                NavigationItem::make('Home')
                    ->icon('heroicon-o-home')
                    ->url(config('app.url'))
                    ->openUrlInNewTab()
                    ->sort(1)
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->discoverPages(
                in: __DIR__.'/../../src/Filament/Pages',
                for: 'Dasundev\\PayHere\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: __DIR__.'/../../src/Filament/Widgets',
                for: 'Dasundev\\PayHere\\Filament\\Widgets'
            )
            ->discoverResources(
                in: __DIR__.'/../../src/Filament/Resources',
                for: 'Dasundev\\PayHere\\Filament\\Resources'
            );
    }
}

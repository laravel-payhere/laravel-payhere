<?php

declare(strict_types=1);

namespace LaravelPayHere\Filament;

use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Auth\Login;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Tables\Table;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use LaravelPayHere\Filament\Middleware\Authenticate;

class PayHerePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('payhere')
            ->path('payhere')
            ->spa()
            ->brandLogo(asset('vendor/payhere/images/logo.svg'))
            ->darkMode()
            ->login(config('payhere.panel_login') ? Login::class : null)
            ->topNavigation()
            ->navigationItems([
                NavigationItem::make('Documentation')
                    ->icon('heroicon-o-book-open')
                    ->url('https://laravel-payhere.com/docs')
                    ->hidden(config('app.env') !== 'local')
                    ->openUrlInNewTab()
                    ->sort(1),
                NavigationItem::make('Knowledge Base')
                    ->icon('heroicon-o-information-circle')
                    ->url('https://support.payhere.lk')
                    ->openUrlInNewTab()
                    ->sort(1),
                NavigationItem::make('Home')
                    ->icon('heroicon-o-home')
                    ->url(config('app.url'))
                    ->openUrlInNewTab()
                    ->sort(2),
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
                for: 'LaravelPayHere\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: __DIR__.'/../../src/Filament/Widgets',
                for: 'LaravelPayHere\\Filament\\Widgets'
            )
            ->discoverResources(
                in: __DIR__.'/../../src/Filament/Resources',
                for: 'LaravelPayHere\\Filament\\Resources'
            )
            ->bootUsing(function () {
                Table::$defaultCurrency = config('payhere.currency');
                Table::$defaultDateTimeDisplayFormat = 'M 5, Y H:i:s A';

                static::ensurePayHerePanelAccessEnabled();
            });
    }

    /**
     * Ensure that access to the PayHere panel is enabled.
     * If not enabled, abort with a 404 error.
     */
    private static function ensurePayHerePanelAccessEnabled(): void
    {
        if (! config('payhere.panel_access')) {
            abort(404);
        }
    }
}

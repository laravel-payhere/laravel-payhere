<?php

namespace Dasundev\PayHere;

use Filament\Tables\Table;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayHereServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('payhere')
            ->hasViews()
            ->runsMigrations()
            ->hasConfigFile()
            ->hasAssets()
            ->hasRoutes(['web', 'api'])
            ->hasMigrations([
                'create_payments_table',
                'create_subscriptions_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('dasundev/laravel-payhere')
                    ->endWith(function (InstallCommand $command) {
                        $command->newLine();
                        $command->info('Thank you so much for purchasing Laravel PayHere package!');
                        $command->info("If you need any assistance, don't hesitate to reach out to me at hello@dasun.dev.");
                    });
            });
    }

    public function registeringPackage(): void
    {
        $this->registerPayHereFacade();
    }

    public function packageRegistered(): void
    {
        $this->registerFilamentCurrency();
    }

    private function registerPayHereFacade(): void
    {
        $this->app->singleton('payhere', fn () => new PayHere);
    }

    private function registerFilamentCurrency(): void
    {
        Table::$defaultCurrency = config('payhere.currency');
    }
}

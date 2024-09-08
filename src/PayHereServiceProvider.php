<?php

declare(strict_types=1);

namespace PayHere;

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
                'create_payhere_payments_table',
                'create_subscriptions_table',
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $command) {
                        $command->newLine();
                        $command->info('Thank you so much for purchasing Laravel PayHere package!');
                        $command->info("If you need any assistance, don't hesitate to reach out to me at hello@dasun.dev.");
                    });
            });
    }

    public function registeringPackage(): void
    {
        // Registering the PayHere facade.
        $this->app->singleton('payhere', fn () => new PayHere);
    }

    public function packageRegistered(): void
    {
        $this->app['config']->set('payhere.base_url', config('payhere.sandbox') ? 'https://sandbox.payhere.lk' : 'https://www.payhere.lk');
    }
}

<?php

declare(strict_types=1);

namespace PayHere;

use Illuminate\Support\Facades\Blade;
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
                        $command->info('Installation completed successfully!');
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

    public function packageBooted(): void
    {
        Blade::directive('payhereJS', function () {
            return "<?php echo view('payhere::js'); ?>";
        });
    }
}

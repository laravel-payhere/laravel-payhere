<?php

namespace Dasundev\PayHere;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PayHereServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('payhere')
            ->hasRoute('web')
            ->hasMigrations([
                'create_payments_table'
            ])
            ->hasViews()
            ->runsMigrations()
            ->hasConfigFile();
    }
}

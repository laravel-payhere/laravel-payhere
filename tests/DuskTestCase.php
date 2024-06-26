<?php

namespace Dasundev\PayHere\Tests;

use Dasundev\PayHere\Filament\PayHerePanelProvider;
use Dasundev\PayHere\PayHereServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;
use Workbench\App\Models\User;
use Workbench\App\Providers\WorkbenchServiceProvider;

abstract class DuskTestCase extends TestCase
{
    use WithWorkbench;

    protected static $baseServeHost = 'localhost';

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('auth.providers.users.model', User::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            PayHereServiceProvider::class,
            PayHerePanelProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }
}

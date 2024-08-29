<?php

declare(strict_types=1);

namespace PayHere\Tests;

use PayHere\Filament\PayHerePanelProvider;
use PayHere\PayHereServiceProvider;
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

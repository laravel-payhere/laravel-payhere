<?php

declare(strict_types=1);

namespace PayHere\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\Dusk\TestCase;
use PayHere\Filament\PayHerePanelProvider;
use PayHere\PayHereServiceProvider;
use Workbench\App\Models\User;
use Workbench\App\Providers\WorkbenchServiceProvider;

abstract class DuskTestCase extends TestCase
{
    use WithWorkbench;
    use RefreshDatabase;

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

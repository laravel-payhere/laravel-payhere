<?php

declare(strict_types=1);

namespace PayHere\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PayHere\PayHereServiceProvider;
use Workbench\App\Providers\WorkbenchServiceProvider;

#[WithMigration]
abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            PayHereServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }
}

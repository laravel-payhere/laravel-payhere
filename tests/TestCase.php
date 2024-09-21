<?php

declare(strict_types=1);

namespace PayHere\Tests;

use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use PayHere\PayHereServiceProvider;
use Workbench\App\Providers\WorkbenchServiceProvider;

#[WithMigration]
abstract class TestCase extends BaseTestCase
{
    use WithWorkbench;

    protected function getPackageProviders($app): array
    {
        return [
            PayHereServiceProvider::class,
            WorkbenchServiceProvider::class,
        ];
    }
}

<?php

namespace LaravelPayHere\Tests;

use LaravelPayHere\PayHereServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Workbench\App\Providers\WorkbenchServiceProvider;

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

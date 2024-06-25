<?php

namespace Dasundev\PayHere\Facades;

use Illuminate\Support\Facades\Facade;

final class PayHere extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'payhere';
    }
}

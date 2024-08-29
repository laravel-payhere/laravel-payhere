<?php

declare(strict_types=1);

namespace PayHere\Exceptions;

use Exception;

class UnsupportedCurrencyException extends Exception
{
    protected $message = 'PayHere only supports payments in LKR, USD, EUR, GBP, and AUD currencies.';
}

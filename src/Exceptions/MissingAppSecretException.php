<?php

declare(strict_types=1);

namespace PayHere\Exceptions;

use Exception;

class MissingAppSecretException extends Exception
{
    protected $message = 'The PAYHERE_APP_SECRET is missing. Please add it to your .env file.';
}

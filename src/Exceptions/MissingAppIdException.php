<?php

declare(strict_types=1);

namespace PayHere\Exceptions;

use Exception;

class MissingAppIdException extends Exception
{
    protected $message = 'The PAYHERE_APP_ID is missing. Please add it to your .env file.';
}

<?php

namespace LaravelPayHere\Exceptions;

use Exception;

class MissingAppSecretException extends Exception
{
    protected $message = 'The PAYHERE_APP_SECRET is missing. Please add it to your .env file.';
}

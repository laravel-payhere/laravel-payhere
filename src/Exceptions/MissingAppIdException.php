<?php

namespace LaravelPayHere\Exceptions;

use Exception;

class MissingAppIdException extends Exception
{
    protected $message = 'The PAYHERE_APP_ID is missing. Please add it to your .env file.';
}

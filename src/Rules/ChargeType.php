<?php

declare(strict_types=1);

namespace PayHere\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ChargeType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $chargeTypes = ['PAYMENT', 'AUTHORIZE'];

        if (! in_array($value, $chargeTypes, true)) {
            $fail('The :attribute must be either PAYMENT or AUTHORIZE.');
        }
    }
}

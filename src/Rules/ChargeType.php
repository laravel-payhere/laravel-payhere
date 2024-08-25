<?php

namespace LaravelPayHere\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use LaravelPayHere\Enums\ChargeType as ChargeTypeEnum;

class ChargeType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! in_array($value, [
            ChargeTypeEnum::PAYMENT->name,
            ChargeTypeEnum::AUTHORIZE->name,
        ], true)) {
            $fail('The :attribute must be either PAYMENT or AUTHORIZE.');
        }
    }
}

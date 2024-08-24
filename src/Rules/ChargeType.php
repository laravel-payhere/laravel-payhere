<?php

namespace LaravelPayHere\Rules;

use Closure;
use LaravelPayHere\Enums\ChargeType as ChargeTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;

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

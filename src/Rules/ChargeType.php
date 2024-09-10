<?php

declare(strict_types=1);

namespace PayHere\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use PayHere\Enums\ChargeType as ChargeTypeEnum;

class ChargeType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! in_array($value, [
            ChargeTypeEnum::Payment->name,
            ChargeTypeEnum::Authorize->name,
        ], true)) {
            $fail('The :attribute must be either PAYMENT or AUTHORIZE.');
        }
    }
}

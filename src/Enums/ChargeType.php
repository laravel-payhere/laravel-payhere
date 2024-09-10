<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum ChargeType: string
{
    case Payment = 'PAYMENT';
    case Authorize = 'AUTHORIZE';
}

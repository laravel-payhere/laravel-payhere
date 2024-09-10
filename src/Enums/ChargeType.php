<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum ChargeType
{
    case Payment;
    case Authorize;
}

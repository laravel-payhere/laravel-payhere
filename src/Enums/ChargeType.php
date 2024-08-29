<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum ChargeType
{
    case PAYMENT;
    case AUTHORIZE;
}

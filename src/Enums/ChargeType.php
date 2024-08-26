<?php

declare(strict_types=1);

namespace LaravelPayHere\Enums;

enum ChargeType
{
    case PAYMENT;
    case AUTHORIZE;
}

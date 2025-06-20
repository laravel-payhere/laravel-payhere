<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum PaymentStatus: int
{
    case AuthorizationSuccess = 3;
    case Success = 2;
    case Pending = 0;
    case Cancelled = -1;
    case Failed = -2;
    case Chargeback = -3;
}

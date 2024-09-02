<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum RefundStatus: int
{
    case Success = 1;
    case Error = 0;
    case Failed = -1;
    case InvalidApiAuthorization = -2;
}

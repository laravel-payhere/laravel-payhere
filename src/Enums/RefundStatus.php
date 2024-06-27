<?php

namespace Dasundev\PayHere\Enums;

enum RefundStatus: int
{
    case REFUND_SUCCESS = 1;
    case REFUND_ERROR = 0;
    case REFUND_FAILED = -1;
    case INVALID_API_AUTHORIZATION = -2;
}

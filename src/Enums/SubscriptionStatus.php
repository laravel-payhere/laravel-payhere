<?php

declare(strict_types=1);

namespace PayHere\Enums;

enum SubscriptionStatus: string
{
    case Active = '0';
    case Completed = '1';
    case Cancelled = '-1';
    case Failed = '-2';
    case Pending = '-3';
}

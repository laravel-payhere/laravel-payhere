<?php

declare(strict_types=1);

namespace PayHere\Enums;

/**
 * Payment methods supported by PayHere.
 */
enum PaymentMethod: string
{
    case VISA = 'VISA';
    case MASTER = 'MASTER';
    case AMEX = 'AMEX';
    case EZCASH = 'EZCASH';
    case MCASH = 'MCASH';
    case GENIE = 'GENIE';
    case VISHWA = 'VISHWA';
    case PAYAPP = 'PAYAPP';
    case HNB = 'HNB';
    case FRIMI = 'FRIMI';
}

<?php

namespace Dasundev\PayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: int implements HasColor, HasLabel
{
    case AUTHORIZATION_SUCCESS = 3;
    case SUCCESS = 2;
    case PENDING = 0;
    case CANCELLED = -1;
    case FAILED = -2;
    case CHARGEBACK = -3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AUTHORIZATION_SUCCESS => 'Authorization Success',
            self::SUCCESS => 'Success',
            self::PENDING => 'Pending',
            self::CANCELLED => 'Cancelled',
            self::FAILED => 'Failed',
            self::CHARGEBACK => 'Chargeback'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AUTHORIZATION_SUCCESS, self::SUCCESS => 'success',
            self::PENDING => 'warning',
            self::CANCELLED => 'gray',
            self::FAILED => 'danger',
            self::CHARGEBACK => 'info'
        };
    }
}

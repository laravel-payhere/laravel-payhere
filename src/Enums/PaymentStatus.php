<?php

declare(strict_types=1);

namespace PayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: int implements HasColor, HasLabel
{
    case AuthorizationSuccess = 3;
    case Success = 2;
    case Pending = 0;
    case Cancelled = -1;
    case Failed = -2;
    case Chargeback = -3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AuthorizationSuccess => 'Authorization Success',
            self::Success => 'Success',
            self::Pending => 'Pending',
            self::Cancelled => 'Cancelled',
            self::Failed => 'Failed',
            self::Chargeback => 'Chargeback'
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AuthorizationSuccess, self::Success => 'success',
            self::Pending => 'warning',
            self::Cancelled => 'gray',
            self::Failed => 'danger',
            self::Chargeback => 'info'
        };
    }
}

<?php

declare(strict_types=1);

namespace PayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus: string implements HasColor, HasLabel
{
    case Active = '0';
    case Completed = '1';
    case Cancelled = '-1';
    case Failed = '-2';
    case Pending = '-3';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Failed => 'Failed',
            self::Pending => 'Pending',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'success',
            self::Completed => 'info',
            self::Cancelled => 'gray',
            self::Failed => 'danger',
            self::Pending => 'warning',
        };
    }
}

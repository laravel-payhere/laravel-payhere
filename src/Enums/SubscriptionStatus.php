<?php

namespace Dasundev\PayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus: string implements HasColor, HasLabel
{
    case Pending = 'Pending';
    case Active = 'Active';
    case Completed = 'Completed';
    case Failed = 'Failed';
    case Cancelled = 'Cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Failed => 'Failed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Cancelled => 'gray',
            self::Active => 'success',
            self::Completed => 'info',
            self::Failed => 'danger',
        };
    }
}

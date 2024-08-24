<?php

namespace LaravelPayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus: int implements HasColor, HasLabel
{
    case Active = 0;
    case Completed = 1;
    case Cancelled = -1;
    case Failed = -2;
    case Pending = -3;

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

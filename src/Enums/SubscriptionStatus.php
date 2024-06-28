<?php

namespace Dasundev\PayHere\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus implements HasColor, HasLabel
{
    case PENDING;
    case TRIALING;
    case ACTIVE;
    case COMPLETED;
    case FAILED;
    case CANCELLED;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::TRIALING => 'Trialing',
            self::ACTIVE => 'Active',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::TRIALING, self::CANCELLED => 'gray',
            self::ACTIVE => 'success',
            self::COMPLETED => 'info',
            self::FAILED => 'danger',
        };
    }
}

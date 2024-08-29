<?php

declare(strict_types=1);

namespace PayHere\Filament\Contracts;

interface PayHerePanelUser
{
    /**
     * Determine if the user can access the PayHere panel.
     */
    public function canAccessPayHerePanel(): bool;
}

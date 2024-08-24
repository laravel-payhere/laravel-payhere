<?php

namespace LaravelPayHere\Filament\Contracts;

interface PayHerePanelUser
{
    /**
     * Determine if the user can access the PayHere panel.
     */
    public function canAccessPayHerePanel(): bool;
}

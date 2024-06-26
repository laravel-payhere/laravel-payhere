<?php

namespace Dasundev\PayHere\Contracts;

interface PayHerePanelUser
{
    /**
     * Determine if the user can access the PayHere panel.
     */
    public function canAccessPayHerePanel(): bool;
}

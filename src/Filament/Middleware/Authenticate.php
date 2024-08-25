<?php

namespace LaravelPayHere\Filament\Middleware;

use Filament\Facades\Filament;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use LaravelPayHere\Filament\Contracts\PayHerePanelUser;

class Authenticate extends Middleware
{
    /**
     * @param  array<string>  $guards
     *
     * @throws AuthenticationException
     */
    protected function authenticate($request, array $guards): void
    {
        $guard = Filament::auth();

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
        }

        $this->auth->shouldUse(Filament::getAuthGuard());

        /** @var Model $user */
        $user = $guard->user();

        abort_if(
            $user instanceof PayHerePanelUser ?
                (! $user->canAccessPayHerePanel()) :
                (config('app.env') !== 'local'),
            403,
        );
    }

    protected function redirectTo($request): ?string
    {
        return Filament::getLoginUrl();
    }
}

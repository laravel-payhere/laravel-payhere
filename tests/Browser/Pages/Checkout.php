<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use PayHere\Tests\Browser\Concerns\HandlesPayment;
use PayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;
use PayHere\Tests\Browser\Concerns\PayHereSiteElements;

class Checkout extends Page
{
    use HandlesPayment;
    use PayHereBrowserAssertions;
    use PayHereSiteElements;

    public function url(): string
    {
        return '/checkout';
    }

    public function assert(Browser $browser): void
    {
        $browser->pause(2000)
            ->assertRouteIs('checkout')
            ->assertTitle('Redirecting to PayHere...');
    }
}

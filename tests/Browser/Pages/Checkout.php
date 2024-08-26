<?php

namespace LaravelPayHere\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use LaravelPayHere\Tests\Browser\Concerns\HandlesPayment;
use LaravelPayHere\Tests\Browser\Concerns\HasPayHereSiteElements;
use LaravelPayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;

class Checkout extends Page
{
    use HandlesPayment;
    use HasPayHereSiteElements;
    use PayHereBrowserAssertions;

    public function url(): string
    {
        return '/checkout';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs('checkout')
            ->assertTitle('Redirecting to PayHere...');
    }
}

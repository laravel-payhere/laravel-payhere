<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use PayHere\Tests\Browser\Concerns\HandlesPayment;
use PayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;
use PayHere\Tests\Browser\Concerns\PayHereSiteElements;

class Recurring extends Page
{
    use HandlesPayment;
    use PayHereBrowserAssertions;
    use PayHereSiteElements;

    public function url(): string
    {
        return '/recurring';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertUrlIs('https://sandbox.payhere.lk/pay/checkout')
            ->assertTitle('Pay with PayHere');
    }
}

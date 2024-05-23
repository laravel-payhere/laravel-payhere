<?php

namespace Dasundev\PayHere\Tests\Browser\Pages;

use Dasundev\PayHere\Tests\Browser\Concerns\HandlesPayment;
use Dasundev\PayHere\Tests\Browser\Concerns\HasPayHereSiteElements;
use Dasundev\PayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Recurring extends Page
{
    use HandlesPayment;
    use HasPayHereSiteElements;
    use PayHereBrowserAssertions;

    public function url(): string
    {
        return '/recurring';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs('recurring')
            ->assertTitle('Redirecting to PayHere...');
    }
}

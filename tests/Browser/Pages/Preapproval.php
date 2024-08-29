<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use PayHere\Tests\Browser\Concerns\HandlesPayment;
use PayHere\Tests\Browser\Concerns\HasPayHereSiteElements;
use PayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;

class Preapproval extends Page
{
    use HandlesPayment;
    use HasPayHereSiteElements;
    use PayHereBrowserAssertions;

    public function url(): string
    {
        return '/preapproval';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs('preapproval')
            ->assertTitle('Redirecting to PayHere...');
    }
}

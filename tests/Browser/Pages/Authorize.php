<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use PayHere\Tests\Browser\Concerns\HandlesPayment;
use PayHere\Tests\Browser\Concerns\PayHereSiteElements;
use PayHere\Tests\Browser\Concerns\PayHereBrowserAssertions;

class Authorize extends Page
{
    use HandlesPayment;
    use PayHereSiteElements;
    use PayHereBrowserAssertions;

    public function url(): string
    {
        return '/authorize';
    }

    public function assert(Browser $browser): void
    {
        $browser->assertRouteIs('authorize')
            ->assertTitle('Redirecting to PayHere...');
    }
}

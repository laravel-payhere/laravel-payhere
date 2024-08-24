<?php

namespace LaravelPayHere\Tests\Browser\Concerns;

use Laravel\Dusk\Browser;

trait PayHereBrowserAssertions
{
    public function assertPaymentApproved(Browser $browser): void
    {
        $browser->waitForRoute('payhere.return')
            ->assertSee('Payment successful')
            ->assertQueryStringHas('order_id');
    }
}

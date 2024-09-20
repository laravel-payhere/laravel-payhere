<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser;

use Laravel\Dusk\Browser;
use PayHere\Tests\Browser\Pages\Checkout;
use Workbench\App\Models\User;

it('can checkout', function () {
    $user = User::factory()->create();
    
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->assertAuthenticated();

        $browser->visit(new Checkout)
            ->payAs($user)
            ->assertPaymentApproved();
    });

    $this->assertDatabaseCount('payhere_payments', 1);
});

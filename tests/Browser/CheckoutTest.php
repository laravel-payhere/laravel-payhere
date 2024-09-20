<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser;

use Laravel\Dusk\Browser;
use PayHere\Tests\Browser\Pages\Authorize;
use PayHere\Tests\Browser\Pages\Checkout;
use PayHere\Tests\Browser\Pages\Preapproval;
use PayHere\Tests\Browser\Pages\Recurring;
use PayHere\Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Test;
use Workbench\App\Models\User;

it('can checkout', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
            ->assertAuthenticatedAs($user);

        $browser->visit(new Checkout)
            ->payAs($user)
            ->assertPaymentApproved();
    });

    $this->assertDatabaseCount('payhere_payments', 1);
});


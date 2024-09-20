<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Concerns\WithWorkbench;
use PayHere\Tests\Browser\Pages\Checkout;
use Workbench\App\Models\User;

uses(WithWorkbench::class);

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

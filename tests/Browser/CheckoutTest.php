<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser;

use Laravel\Dusk\Browser;
use PayHere\Tests\Browser\Pages\Authorize;
use PayHere\Tests\Browser\Pages\Checkout;
use PayHere\Tests\Browser\Pages\Preapproval;
use PayHere\Tests\Browser\Pages\Recurring;
use PayHere\Tests\DuskTestCase;
use Workbench\App\Models\User;

class CheckoutTest extends DuskTestCase
{
    public function test_normal_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Checkout)
                ->payAs($user)
                ->assertPaymentApproved();
        });

        $this->assertDatabaseCount('payhere_payments', 1);
    }

    public function test_authorize_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Authorize)
                ->payAs($user)
                ->assertPaymentApproved();
        });

        $this->assertDatabaseCount('payhere_payments', 1);
    }

    public function test_preapprove_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Preapproval)
                ->payAs($user)
                ->assertPaymentApproved();
        });

        $this->assertDatabaseCount('payhere_payments', 1);
    }

    public function test_recurring_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Recurring)
                ->payAs($user)
                ->assertPaymentApproved();
        });

        $this->assertDatabaseCount('payhere_payments', 1);
    }
}

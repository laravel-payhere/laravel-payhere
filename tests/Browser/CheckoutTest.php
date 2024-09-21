<?php

declare(strict_types=1);

namespace PayHere\Tests\Browser;

use Laravel\Dusk\Browser;
use Orchestra\Testbench\Attributes\WithMigration;
use PayHere\Tests\Browser\Pages\Checkout;
use PayHere\Tests\DuskTestCase;
use Workbench\App\Models\User;

class CheckoutTest extends DuskTestCase
{
    #[WithMigration]
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
}

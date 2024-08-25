<?php

namespace LaravelPayHere\Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use LaravelPayHere\Tests\Browser\Pages\Authorize;
use LaravelPayHere\Tests\Browser\Pages\Checkout;
use LaravelPayHere\Tests\Browser\Pages\Preapproval;
use LaravelPayHere\Tests\Browser\Pages\Recurring;
use LaravelPayHere\Tests\DuskTestCase;
use Orchestra\Testbench\Attributes\WithMigration;
use PHPUnit\Framework\Attributes\Test;
use Workbench\App\Models\User;

class CheckoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    #[Test]
    #[WithMigration]
    public function it_can_process_a_payment_for_normal_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Checkout)
                ->payAs($user)
                ->assertPaymentApproved();
        });
    }

    #[Test]
    #[WithMigration]
    public function it_can_process_a_payment_for_authorize_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Authorize)
                ->payAs($user)
                ->assertPaymentApproved();
        });
    }

    #[Test]
    #[WithMigration]
    public function it_can_process_a_payment_for_preapproval_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Preapproval)
                ->payAs($user)
                ->assertPaymentApproved();
        });
    }

    #[Test]
    #[WithMigration]
    public function it_can_process_a_payment_for_recurring_checkout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->assertAuthenticatedAs($user);

            $browser->visit(new Recurring)
                ->payAs($user)
                ->assertPaymentApproved();
        });
    }
}

<?php

use Illuminate\Support\Facades\URL;
use LaravelPayHere\Enums\SubscriptionStatus;
use LaravelPayHere\Models\OrderItem;
use LaravelPayHere\Models\Subscription;
use LaravelPayHere\Models\Order;

it('can handle webhook for normal checkout', function () {
    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->create();

    $uri = URL::signedRoute('payhere.webhook');

    $data = [
        'merchant_id' => config('payhere.merchant_id'),
        'order_id' => 1,
        'payment_id' => 320032387268,
        'captured_amount' => 1000.00,
        'payhere_amount' => 1000.00,
        'payhere_currency' => 'LKR',
        'status_code' => 2,
        'md5sig' => 'C7A4E240E6927F2F580BFEE05E5BC8B0',
        'status_message' => 'Successfully received the VISA payment',
        'method' => 'VISA',
        'card_holder_name' => 'Dasun Tharanga',
        'card_no' => '************1292',
        'card_expiry' => '09/06',
        'recurring' => 0,
    ];

    $this->post($uri, $data);

    $this->assertDatabaseHas('orders', ['id' => $order->id]);
    $this->assertDatabaseCount('payhere_payments', 1);
    $this->assertDatabaseEmpty('subscriptions');
});

it('can handle webhook for authorize checkout', function () {
    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->create();

    $uri = URL::signedRoute('payhere.webhook');

    $data = [
        'merchant_id' => config('payhere.merchant_id'),
        'order_id' => 1,
        'authorization_token' => '8cb9984c-10b5-4612-8047-5394ca584aa9',
        'payhere_amount' => 1000.00,
        'payhere_currency' => 'LKR',
        'status_code' => 3,
        'md5sig' => 'BD72AC93E8685273093DE0737C9E668C',
        'status_message' => 'Successfully received the VISA payment',
        'method' => 'VISA',
        'card_holder_name' => 'Dasun Tharanga',
        'card_no' => '************1292',
        'card_expiry' => '09/06',
        'recurring' => 0,
    ];

    $this->post($uri, $data);

    $this->assertDatabaseHas('orders', ['id' => $order->id]);
    $this->assertDatabaseCount('payhere_payments', 1);
    $this->assertDatabaseEmpty('subscriptions');
});

it('can handle webhook for preapproval checkout', function () {
    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->create();

    $uri = URL::signedRoute('payhere.webhook');

    $data = [
        'merchant_id' => config('payhere.merchant_id'),
        'order_id' => 1,
        'payment_id' => '320032387270',
        'payhere_amount' => 1000.00,
        'payhere_currency' => 'LKR',
        'status_code' => 2,
        'md5sig' => 'C7A4E240E6927F2F580BFEE05E5BC8B0',
        'status_message' => 'Successfully received the VISA payment',
        'method' => 'VISA',
        'card_holder_name' => 'Dasun Tharanga',
        'card_no' => '************1292',
        'card_expiry' => '09/06',
        'recurring' => 0,
        'customer_token' => '25995925C631FEF3AF5C11DD8496D7AA',
    ];

    $this->post($uri, $data);

    $this->assertDatabaseHas('orders', ['id' => $order->id]);
    $this->assertDatabaseCount('payhere_payments', 1);
    $this->assertDatabaseEmpty('subscriptions');
});

it('can handle webhook for recurring checkout', function () {
    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->has(Subscription::factory(), 'subscription')
        ->create();

    $uri = URL::signedRoute('payhere.webhook');

    $data = [
        'merchant_id' => config('payhere.merchant_id'),
        'order_id' => 1,
        'payment_id' => '320032387276',
        'payhere_amount' => 1000.00,
        'payhere_currency' => 'LKR',
        'status_code' => 2,
        'md5sig' => 'C7A4E240E6927F2F580BFEE05E5BC8B0',
        'status_message' => 'Successfully received the VISA payment',
        'method' => 'VISA',
        'card_holder_name' => 'Dasun Tharanga',
        'card_no' => '************1292',
        'card_expiry' => '09/06',
        'recurring' => 1,
        'message_type' => 'RECURRING_INSTALLMENT_SUCCESS',
        'item_recurrence' => '1 MONTH',
        'item_duration' => '1 YEAR',
        'item_rec_status' => 0,
        'item_rec_date_next' => '2024-05-24',
        'item_rec_install_paid' => '2',
        'subscription_id' => '420075044317',
        'custom_1' => '1',
    ];

    $this->post($uri, $data);

    $this->assertDatabaseHas('orders', ['id' => $order->id]);
    $this->assertDatabaseCount('payhere_payments', 1);
    $this->assertDatabaseHas('subscriptions', [
        'id' => $order->subscription->id,
        'status' => SubscriptionStatus::Active->value,
    ]);
});

it('can handle webhook for a payment charge', function () {
    $order = Order::factory()
        ->has(OrderItem::factory()->count(2), 'items')
        ->has(Subscription::factory(), 'subscription')
        ->create();

    $uri = URL::signedRoute('payhere.webhook');

    $data = [
        'merchant_id' => config('payhere.merchant_id'),
        'order_id' => 1,
        'payment_id' => '320032387276',
        'payhere_amount' => 1000.00,
        'captured_amount' => 1000.00,
        'payhere_currency' => 'LKR',
        'status_code' => 2,
        'md5sig' => 'C7A4E240E6927F2F580BFEE05E5BC8B0',
        'status_message' => 'Successfully received the VISA payment',
        'method' => 'VISA',
        'card_holder_name' => 'Dasun Tharanga',
        'card_no' => '************1292',
        'card_expiry' => '09/06',
        'recurring' => 0,
    ];

    $this->post($uri, $data);

    $this->assertDatabaseHas('orders', ['id' => $order->id]);
    $this->assertDatabaseCount('payhere_payments', 1);
});

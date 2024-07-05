<?php

use Dasundev\PayHere\Models\Subscription;
use Workbench\App\Models\Order;
use Workbench\App\Models\User;

test('to array', function () {
    $payment = Subscription::factory()->create()->fresh();

    expect(array_keys($payment->toArray()))->toBe([
        'id',
        'payhere_subscription_id',
        'user_id',
        'order_id',
        'trial_ends_at',
        'ends_at',
        'status',
        'created_at',
        'updated_at',
    ]);
});

test('relations', function () {
    $subscription = Subscription::factory()->create();

    expect($subscription->user)->toBeInstanceOf(User::class)
        ->and($subscription->order)->toBeInstanceOf(Order::class);
});

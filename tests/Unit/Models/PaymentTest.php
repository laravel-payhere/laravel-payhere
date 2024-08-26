<?php

use LaravelPayHere\Models\Payment;
use Workbench\App\Models\Order;
use Workbench\App\Models\User;

test('to array', function () {
    $payment = Payment::factory()->create()->fresh();

    expect(array_keys($payment->toArray()))->toBe([
        'id',
        'user_id',
        'order_id',
        'merchant_id',
        'payment_id',
        'refunded',
        'refund_reason',
        'subscription_id',
        'payhere_amount',
        'captured_amount',
        'payhere_currency',
        'status_code',
        'status_message',
        'method',
        'card_holder_name',
        'card_no',
        'card_expiry',
        'recurring',
        'message_type',
        'item_recurrence',
        'item_duration',
        'item_rec_status',
        'item_rec_date_next',
        'item_rec_install_paid',
        'custom_1',
        'custom_2',
        'created_at',
        'updated_at',
    ]);
});

test('relations', function () {
    $payment = Payment::factory()->create();

    expect($payment->user)->toBeInstanceOf(User::class)
        ->and($payment->order)->toBeInstanceOf(Order::class);
});

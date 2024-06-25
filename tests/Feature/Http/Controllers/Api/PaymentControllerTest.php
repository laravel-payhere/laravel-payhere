<?php

use Dasundev\PayHere\Models\Payment;
use Illuminate\Routing\Middleware\ValidateSignature;

it('can search payments without an order id', function () {
    $response = $this->getJson('payhere/api/payments/search');

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['status', 'msg', 'data'])
        ->assertJsonFragment(['status' => 1]);
});

it('can search payments with an order id', function () {
    $response = $this->getJson('payhere/api/payments/search?order_id=9c1efa4c-61a6-4dbe-9c8f-933e40e1216c');

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['status', 'msg', 'data'])
        ->assertJsonFragment([
            'status' => 1,
            'msg' => 'Payments with order_id:9c1efa4c-61a6-4dbe-9c8f-933e40e1216c',
            'description' => 'Order #9c1efa4c-61a6-4dbe-9c8f-933e40e1216c',
        ]);
});

it('can not charge payment without order id', function () {
    $response = $this->postJson('payhere/api/payments/charge', [
        'type' => 'PAYMENT',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['order_id']);
});

it('can charge payment', function () {
    $payment = Payment::factory()
        ->state(['customer_token' => '4898B950FE2F7E000965D6CA322FB02F'])
        ->create();

    $response = $this->postJson('payhere/api/payments/charge', [
        'order_id' => $payment->order->id,
        'type' => 'PAYMENT',
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['status', 'msg', 'data'])
        ->assertJsonFragment([
            'status' => 1,
            'msg' => 'Automatic payment charged successfully',
        ]);
});

<?php

it('can fetch all subscriptions', function () {
    $response = $this->getJson('payhere/api/subscriptions');

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['status', 'msg', 'data'])
        ->assertJsonFragment(['status' => 1]);
});

it('can fetch all payments of a subscription', function () {
    $response = $this->getJson('payhere/api/subscriptions/420075044282');

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['status', 'msg', 'data'])
        ->assertJsonFragment(['status' => 1]);
});

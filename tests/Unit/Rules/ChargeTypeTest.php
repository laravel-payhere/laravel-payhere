<?php

use LaravelPayHere\Rules\ChargeType;

test('valid charge type', function ($chargeType) {
    $rule = new ChargeType();

    $fail = fn (string $errorMessage) => $this->fail($errorMessage);

    $rule->validate('type', $chargeType, $fail);

    expect(true)->toBeTrue();
})->with([
    'PAYMENT',
    'AUTHORIZE',
]);

test('invalid charge type', function ($chargeType) {
    $rule = new ChargeType();

    $fail = fn (string $errorMessage) => $this->fail($errorMessage);

    $rule->validate('type', $chargeType, $fail);

    expect(true)->toBeTrue();
})->with([
    'NOT EXISTS',
])->fails();

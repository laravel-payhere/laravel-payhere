<?php

namespace Dasundev\PayHere\Concerns;

use Dasundev\PayHere\PayHere;
use Illuminate\Support\Facades\URL;

trait CheckoutForm
{
    public function getForm(): array
    {
        return array_merge(
            ['customer' => $this->customer()],
            ['items' => $this->items()],
            ['other' => $this->other()]
        );
    }

    private function customer(): array
    {
        $relationship = PayHere::$customerRelationship;

        return [
            'first_name' => $this->order->{$relationship}->payhereFirstName(),
            'last_name' => $this->order->{$relationship}->payhereLastName(),
            'email' => $this->order->{$relationship}->payhereEmail(),
            'phone' => $this->order->{$relationship}->payherePhone(),
            'address' => $this->order->{$relationship}->payhereAddress(),
            'city' => $this->order->{$relationship}->payhereCity(),
            'country' => $this->order->{$relationship}->payhereCountry(),
        ];
    }

    private function items(): array
    {
        $relationship = PayHere::$orderLinesRelationship;

        $items = [];

        foreach ($this->order->{$relationship} as $number => $line) {
            $items["item_number_$number"] = $line->payHereOrderLineId();
            $items["item_name_$number"] = $line->payHereOrderLineTitle();
            $items["quantity_$number"] = $line->payHereOrderLineQty();
            $items["amount_$number"] = $line->payHereOrderLineTotal();
        }

        return $items;
    }

    private function other(): array
    {
        $baseUrl = config('payhere.base_url');

        return [
            'action' => "$baseUrl/pay/checkout",
            'merchant_id' => config('payhere.merchant_id'),
            'return_url' => config('payhere.return_url'),
            'cancel_url' => config('payhere.cancel_url'),
            'notify_url' => URL::signedRoute('payhere.webhook'),
            'order_id' => $this->order->id,
            'items' => "Order #{$this->order->id}",
            'currency' => config('payhere.currency'),
            'amount' => $this->order->total,
            'hash' => $this->generateHash(),
        ];
    }

    public function recurring(string $recurrence, string $duration): array
    {
        return array_merge($this->getForm(), ['recurrence' => $recurrence, 'duration' => $duration]);
    }
}
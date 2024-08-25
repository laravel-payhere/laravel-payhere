<?php

namespace LaravelPayHere\Http\Integrations\PayHere\Requests;

use Exception;
use Illuminate\Support\Facades\URL;
use LaravelPayHere\PayHere;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PaymentChargeRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $orderId,
        private readonly ?string $type = null,
        private readonly ?string $customOne = null,
        private readonly ?string $customTwo = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/payment/charge';
    }

    /**
     * @throws Exception
     */
    protected function defaultBody(): array
    {
        $order = PayHere::$orderModel::find($this->orderId);

        return [
            'type' => $this->type,
            'order_id' => $order->id,
            'custom_1' => $this->customOne,
            'custom_2' => $this->customTwo,
            'customer_token' => $order->payment->customer_token,
            'items' => "Order #{$order->id}",
            'amount' => $order->total,
            'currency' => config('payhere.currency'),
            'notify_url' => config('payhere.notify_url') ?? URL::signedRoute('payhere.webhook'),
            'itemList' => $order->items->map(function ($line) {
                return [
                    'name' => $line->payHereOrderLineTitle(),
                    'number' => $line->payHereOrderLineId(),
                    'quantity' => $line->payHereOrderLineQty(),
                    'unit_amount' => $line->payHereOrderLineUnitPrice(),
                ];
            }),
        ];
    }
}

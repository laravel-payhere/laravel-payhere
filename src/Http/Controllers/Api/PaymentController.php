<?php

namespace LaravelPayHere\Http\Controllers\Api;

use Illuminate\Http\Request;
use JsonException;
use LaravelPayHere\Http\Integrations\PayHere\PayHereConnector;
use LaravelPayHere\Http\Integrations\PayHere\Requests\CapturePaymentRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\ListPaymentsRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\PaymentChargeRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use LaravelPayHere\Rules\ChargeType;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class PaymentController
{
    private PayHereConnector $connector;

    public function __construct()
    {
        $this->connector = new PayHereConnector;

        $authenticator = $this->connector->getAccessToken();

        $this->connector->authenticate($authenticator);
    }

    /**
     * Search for payments by order ID.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function search(Request $request)
    {
        $orderId = $request->input('order_id');

        $response = $this->connector->send(new ListPaymentsRequest($orderId));

        return $response->json();
    }

    /**
     * Charge a payment.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function charge(Request $request)
    {
        $request->validate([
            'type' => ['sometimes', 'string', new ChargeType],
            'order_id' => ['required'],
            'custom_1' => ['sometimes', 'string'],
            'custom_2' => ['sometimes', 'string'],
        ]);

        $response = $this->connector->send(new PaymentChargeRequest(
            orderId: $request->order_id,
            type: $request->type,
            customOne: $request->custom_1,
            customTwo: $request->custom_2
        ));

        return $response->json();
    }

    /**
     * Capture a payment.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function capture(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string'],
            'authorization_token' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        $response = $this->connector->send(new CapturePaymentRequest(
            description: $request->description,
            authorizationToken: $request->authorization_token,
            amount: $request->amount
        ));

        return $response->json();
    }

    /**
     * Refund a payment.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function refund(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string'],
            'payment_id' => ['sometimes', 'string'],
            'authorization_token' => ['sometimes', 'string'],
        ]);

        $response = $this->connector->send(new RefundPaymentRequest(
            paymentId: $request->payment_id,
            description: $request->description,
            authorizationToken: $request->authorization_token
        ));

        return $response->json();
    }
}

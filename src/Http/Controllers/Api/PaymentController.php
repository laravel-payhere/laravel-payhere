<?php

declare(strict_types=1);

namespace PayHere\Http\Controllers\Api;

use Illuminate\Http\Request;
use JsonException;
use PayHere\Http\Integrations\PayHere\PayHereConnector;
use PayHere\Http\Integrations\PayHere\Requests\CapturePaymentRequest;
use PayHere\Http\Integrations\PayHere\Requests\ListPaymentsRequest;
use PayHere\Http\Integrations\PayHere\Requests\PaymentChargeRequest;
use PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use PayHere\Models\Payment;
use PayHere\Rules\ChargeType;
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
     * Retrieve payments by order ID.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function show($orderId)
    {
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

        $response = $this->connector->send(new PaymentChargeRequest($request->all()));

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

        $response = $this->connector->send(new CapturePaymentRequest($request->all()));

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

        $response = $this->connector->send(new RefundPaymentRequest($request->all()));

        return $response->json();
    }
}

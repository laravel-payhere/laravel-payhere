<?php

namespace Dasundev\PayHere\Services;

use Dasundev\PayHere\Enums\RefundStatus;
use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Services\Contracts\PayHereService;

class PayHereApiService implements PayHereService
{
    public function refund(Payment $payment, ?string $reason = null): array
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RefundPaymentRequest(
            paymentId: $payment->payment_id,
            description: $reason
        ));

        $payload = $response->json();

        $status = $payload['status'];

        if ((int) $status === RefundStatus::REFUND_SUCCESS->value) {
            $payment->markAsRefunded($reason);
        }

        return $payload;
    }
}
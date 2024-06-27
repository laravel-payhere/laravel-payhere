<?php

namespace Dasundev\PayHere\Services;

use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use Dasundev\PayHere\Services\Contracts\PayHereService;

class PayHereApiService implements PayHereService
{
    public function refund(string $paymentId, ?string $reason = null): array
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RefundPaymentRequest(
            paymentId: $paymentId,
            description: $reason
        ));

        return $response->json();
    }
}
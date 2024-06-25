<?php

namespace Dasundev\PayHere\Concerns;

use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;

/**
 * @property $payment
 */
class HasRefund
{
    public function refund(?string $reason = null): bool
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RefundPaymentRequest(
            description: $reason,
            paymentId: $this->payment->payment_id,
        ));

        return $response->ok();
    }
}

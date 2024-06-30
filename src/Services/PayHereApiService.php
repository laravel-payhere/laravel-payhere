<?php

namespace Dasundev\PayHere\Services;

use Dasundev\PayHere\Events\SubscriptionActivated;
use Dasundev\PayHere\Events\SubscriptionCancelled;
use Dasundev\PayHere\Events\SubscriptionRetrySucceeded;
use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\CancelSubscriptionRequest;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RetrySubscriptionRequest;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\Models\Subscription;
use Dasundev\PayHere\Services\Contracts\PayHereService;

class PayHereApiService implements PayHereService
{
    public function refundPayment(Payment $payment, ?string $reason = null): array
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

        if ((int) $status === 1) {
            $payment->markAsRefunded($reason);
        }

        return $payload;
    }

    public function cancelSubscription(Subscription $subscription): array
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new CancelSubscriptionRequest($subscription->payhere_subscription_id));

        $payload = $response->json();

        $status = $payload['status'];

        if ((int) $status === 1) {
            $subscription->markAsCancelled();

            SubscriptionCancelled::dispatch($subscription);
        }

        return $payload;
    }

    public function retrySubscription(Subscription $subscription): array
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RetrySubscriptionRequest($subscription->payhere_subscription_id));

        $payload = $response->json();

        $status = $payload['status'];

        if ((int) $status === 1) {
            $subscription->markAsActive();

            SubscriptionRetrySucceeded::dispatch($subscription);
        }

        return $payload;
    }
}

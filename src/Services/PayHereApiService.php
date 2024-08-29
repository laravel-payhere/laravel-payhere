<?php

declare(strict_types=1);

namespace PayHere\Services;

use PayHere\Events\PaymentRefunded;
use PayHere\Events\SubscriptionCancelled;
use PayHere\Events\SubscriptionRetrySucceeded;
use PayHere\Http\Integrations\PayHere\PayHereConnector;
use PayHere\Http\Integrations\PayHere\Requests\CancelSubscriptionRequest;
use PayHere\Http\Integrations\PayHere\Requests\RefundPaymentRequest;
use PayHere\Http\Integrations\PayHere\Requests\RetrySubscriptionRequest;
use PayHere\Models\Payment;
use PayHere\Models\Subscription;
use PayHere\Services\Contracts\PayHereService;

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

            PaymentRefunded::dispatch($payment);
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

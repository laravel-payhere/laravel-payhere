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
    private PayHereConnector $connector;

    public function __construct()
    {
        $this->connector = new PayHereConnector;

        $authenticator = $this->connector->getAccessToken();

        $this->connector->authenticate($authenticator);
    }

    public function refundPayment(Payment $payment, ?string $reason = null): array
    {
        $response = $this->connector->send(new RefundPaymentRequest(
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
        $response = $this->connector->send(new CancelSubscriptionRequest($subscription->payhere_subscription_id));

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
        $response = $this->connector->send(new RetrySubscriptionRequest($subscription->payhere_subscription_id));

        $payload = $response->json();

        $status = $payload['status'];

        if ((int) $status === 1) {
            $subscription->markAsActive();

            SubscriptionRetrySucceeded::dispatch($subscription);
        }

        return $payload;
    }
}

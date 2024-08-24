<?php

namespace LaravelPayHere\Http\Controllers\Api;

use LaravelPayHere\Http\Integrations\PayHere\PayHereConnector;
use LaravelPayHere\Http\Integrations\PayHere\Requests\CancelSubscriptionRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\GetSubscriptionRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\ListSubscriptionsRequest;
use LaravelPayHere\Http\Integrations\PayHere\Requests\RetrySubscriptionRequest;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class SubscriptionController
{
    private PayHereConnector $connector;

    public function __construct()
    {
        $this->connector = new PayHereConnector;

        $authenticator = $this->connector->getAccessToken();

        $this->connector->authenticate($authenticator);
    }

    /**
     * Retrieves all subscriptions from PayHere.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function index()
    {
        $response = $this->connector->send(new ListSubscriptionsRequest);

        return $response->json();
    }

    /**
     * Retrieves details of a specific subscription from PayHere.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function show(string $subscription)
    {
        $response = $this->connector->send(new GetSubscriptionRequest($subscription));

        return $response->json();
    }

    /**
     * Retry a failed payment for a subscription.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function retry(string $subscription)
    {
        $response = $this->connector->send(new RetrySubscriptionRequest($subscription));

        return $response->json();
    }

    /**
     * Cancel a subscription.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function cancel(string $subscription)
    {
        $response = $this->connector->send(new CancelSubscriptionRequest($subscription));

        return $response->json();
    }
}

<?php

declare(strict_types=1);

namespace PayHere\Http\Controllers\Api;

use JsonException;
use PayHere\Http\Integrations\PayHere\PayHereConnector;
use PayHere\Http\Integrations\PayHere\Requests\CancelSubscriptionRequest;
use PayHere\Http\Integrations\PayHere\Requests\GetSubscriptionRequest;
use PayHere\Http\Integrations\PayHere\Requests\ListSubscriptionsRequest;
use PayHere\Http\Integrations\PayHere\Requests\RetrySubscriptionRequest;
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
    public function show(string $subscriptionId)
    {
        $response = $this->connector->send(new GetSubscriptionRequest($subscriptionId));

        return $response->json();
    }

    /**
     * Retry a failed payment for a subscription.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function retry(string $subscriptionId)
    {
        $response = $this->connector->send(new RetrySubscriptionRequest($subscriptionId));

        return $response->json();
    }

    /**
     * Cancel a subscription.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function cancel(string $subscriptionId)
    {
        $response = $this->connector->send(new CancelSubscriptionRequest($subscriptionId));

        return $response->json();
    }
}

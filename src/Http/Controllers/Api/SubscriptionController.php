<?php

namespace Dasundev\PayHere\Http\Controllers\Api;

use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\CancelSubscriptionRequest;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\GetSubscriptionRequest;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RetrieveSubscriptionsRequest;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\RetrySubscriptionRequest;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class SubscriptionController
{
    /**
     * Retrieves all subscriptions from PayHere.
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function index()
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RetrieveSubscriptionsRequest);

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
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new GetSubscriptionRequest($subscription));

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
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new RetrySubscriptionRequest(
            subscription: $subscription
        ));

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
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new CancelSubscriptionRequest(
            subscription: $subscription
        ));

        return $response->json();
    }
}

<?php

namespace Dasundev\PayHere\Http\Controllers\Api;

use Dasundev\PayHere\Http\Integrations\PayHere\PayHereConnector;
use Dasundev\PayHere\Http\Integrations\PayHere\Requests\ListPaymentsRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class RetrievalController extends Controller
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function __invoke(string $order)
    {
        $connector = new PayHereConnector;

        $authenticator = $connector->getAccessToken();

        $connector->authenticate($authenticator);

        $response = $connector->send(new ListPaymentsRequest(
            orderId: $order
        ));

        return $response->json();
    }
}

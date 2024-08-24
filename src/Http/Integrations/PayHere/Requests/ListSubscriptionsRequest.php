<?php

namespace LaravelPayHere\Http\Integrations\PayHere\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListSubscriptionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/subscription';
    }
}

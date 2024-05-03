<?php

namespace Dasundev\PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class RetrieveSubscriptionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/subscription';
    }
}

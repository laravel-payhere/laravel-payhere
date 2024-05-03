<?php

namespace Dasundev\PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class GetSubscriptionRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly string $subscription
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "merchant/v1/subscription/$this->subscription/payments";
    }
}

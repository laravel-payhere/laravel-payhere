<?php

namespace Dasundev\PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;

class RetrySubscriptionRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $subscription
    ) {
    }

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/subscription/retry';
    }

    protected function defaultBody(): array
    {
        return [
            'subscription_id' => $this->subscription,
        ];
    }
}

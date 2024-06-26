<?php

namespace Dasundev\PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CancelSubscriptionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $subscription
    ) {}

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/subscription/cancel';
    }

    protected function defaultBody(): array
    {
        return [
            'subscription_id' => $this->subscription,
        ];
    }
}

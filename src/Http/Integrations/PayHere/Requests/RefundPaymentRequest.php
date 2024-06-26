<?php

namespace Dasundev\PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class RefundPaymentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $description,
        private readonly ?string $paymentId = null,
        private readonly ?string $authorizationToken = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/payment/refund';
    }

    protected function defaultBody(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'description' => $this->description,
            'authorization_token' => $this->authorizationToken,
        ];
    }
}

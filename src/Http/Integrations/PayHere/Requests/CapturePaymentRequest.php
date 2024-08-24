<?php

namespace LaravelPayHere\Http\Integrations\PayHere\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CapturePaymentRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        private readonly string $description,
        private readonly string $authorizationToken,
        private readonly float $amount,
    ) {}

    public function resolveEndpoint(): string
    {
        return 'merchant/v1/payment/capture';
    }

    protected function defaultBody(): array
    {
        return [
            'deduction_details' => $this->description,
            'authorization_token' => $this->authorizationToken,
            'amount' => $this->amount,
        ];
    }
}

<?php

declare(strict_types=1);

namespace PayHere\Http\Integrations\PayHere\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListPaymentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        private readonly ?string $orderId
    ) {}

    public function resolveEndpoint(): string
    {
        return '/merchant/v1/payment/search';
    }

    protected function defaultQuery(): array
    {
        return [
            'order_id' => $this->orderId,
        ];
    }
}

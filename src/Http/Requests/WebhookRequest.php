<?php

declare(strict_types=1);

namespace PayHere\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    public function isRecurring(): bool
    {
        return (int) $this->request->get('recurring') === 1;
    }
}

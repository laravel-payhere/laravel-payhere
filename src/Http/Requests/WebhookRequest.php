<?php

namespace LaravelPayHere\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    public function isRecurring(): bool
    {
        return (int) $this->request->get('recurring') === 1;
    }
}

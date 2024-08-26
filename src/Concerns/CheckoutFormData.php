<?php

declare(strict_types=1);

namespace LaravelPayHere\Concerns;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelPayHere\Exceptions\UnsupportedCurrencyException;
use LaravelPayHere\Models\Contracts\PayHereCustomer;
use LaravelPayHere\Models\Contracts\PayHereOrder;
use LaravelPayHere\PayHere;

/**
 * @method string payhereFirstName()
 * @method string payhereLastName()
 * @method string payhereEmail()
 * @method string payherePhone()
 * @method string payhereAddress()
 * @method string payhereCity()
 * @method string payhereCountry()
 */
trait CheckoutFormData
{
    /**
     * Recurring payment details.
     */
    private ?array $recurring = null;

    /**
     * Indicates if preapproval is required.
     */
    private bool $preapproval = false;

    /**
     * Indicates if authorization is required.
     */
    private bool $authorize = false;

    /**
     * Platform information.
     */
    private ?string $platform = null;

    /**
     * Startup fee amount.
     */
    private ?float $startupFee = null;

    /**
     * Custom data for the checkout form.
     */
    private ?array $customData = null;

    /**
     * Item name.
     */
    private ?string $item = null;

    /**
     * The title of the transaction.
     */
    private ?string $title = null;

    /**
     * Items
     */
    private ?array $items = [];

    /**
     * The currency code for the transaction.
     */
    private ?string $currency = null;

    /**
     * The order id for the transaction.
     */
    private ?string $orderId = null;

    /**
     * The amount of the transaction.
     */
    private ?float $amount = null;

    /**
     * Get the form data for the checkout.
     */
    public function getFormData(): array
    {
        return [
            'customer' => $this->customer(),
            'items' => $this->getItems(),
            'other' => $this->other(),
            'recurring' => $this->recurring,
            'platform' => $this->platform,
            'startup_fee' => $this->startupFee,
            'custom_1' => $this->customData['custom_1'] ?? null,
            'custom_2' => $this->customData['custom_2'] ?? null,
        ];
    }

    /**
     * Get customer details for the form.
     */
    private function customer(): array
    {
        $customer = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'country' => '',
        ];

        if (! $this instanceof PayHereCustomer) {
            return $customer;
        }

        return [
            'first_name' => $this->payhereFirstName(),
            'last_name' => $this->payhereLastName(),
            'email' => $this->payhereEmail(),
            'phone' => $this->payherePhone(),
            'address' => $this->payhereAddress(),
            'city' => $this->payhereCity(),
            'country' => $this->payhereCountry(),
        ];
    }

    /**
     * Get item details for the form.
     */
    private function items(array $items): string|array
    {
        return $items;
    }

    /**
     * Get other necessary details for the form.
     */
    private function other(): array
    {
        return [
            'action' => $this->actionUrl(),
            'merchant_id' => config('payhere.merchant_id'),
            'notify_url' => config('payhere.notify_url') ?? URL::signedRoute('payhere.webhook'),
            'return_url' => config('payhere.return_url') ?? URL::signedRoute('payhere.return'),
            'cancel_url' => config('payhere.cancel_url') ?? url('/'),
            'order_id' => $this->getOrderId(),
            'currency' => $this->getCurrency(),
            'amount' => $this->amount,
            'hash' => $this->generateHash(),
        ];
    }

    /**
     * Set preapproval for the payment.
     */
    public function preapproval(): static
    {
        $this->preapproval = true;

        return $this;
    }

    /**
     * Set authorization for the payment.
     */
    public function authorize(): static
    {
        $this->authorize = true;

        return $this;
    }

    /**
     * Generate the action URL for the form.
     */
    private function actionUrl(): string
    {
        $baseUrl = config('payhere.base_url');
        $action = 'checkout';

        if ($this->preapproval) {
            $action = 'preapprove';
        }

        if ($this->authorize) {
            $action = 'authorize';
        }

        return "$baseUrl/pay/$action";
    }

    /**
     * Set recurring payment details.
     */
    public function recurring(string $recurrence, string $duration): static
    {
        $this->recurring = [
            'recurrence' => $recurrence,
            'duration' => $duration,
        ];

        $subscription = $this->subscriptions()->create([
            'user_id' => $this->id,
            'order_id' => $this->getOrderId(),
            'ends_at' => now()->add($duration),
            'trial_ends_at' => $this->trialEndsAt,
        ]);

        $this->customData($subscription->id);

        return $this;
    }

    /**
     * Set the platform for the form.
     */
    public function platform(string $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Set the startup fee for the form.
     */
    public function startupFee(float $fee): static
    {
        $this->startupFee = $fee;

        return $this;
    }

    /**
     * Set the startup fee for the form.
     */
    public function orderId(string $id): static
    {
        $this->orderId = $id;

        return $this;
    }

    /**
     * Set custom data for the form.
     */
    private function customData(string ...$data): static
    {
        $this->customData = [
            'custom_1' => $data[0] ?? null,
            'custom_2' => $data[1] ?? null,
        ];

        return $this;
    }

    /**
     * Set the name of item.
     */
    public function item(string $item): static
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Set the name of currency for the transaction.
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the amount of currency for the transaction.
     */
    public function amount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Generate a hash string.
     *
     * The hash value is required starting from 2023-01-16.
     */
    private function generateHash(): string
    {
        return strtoupper(
            md5(
                config('payhere.merchant_id').
                $this->getOrderId().
                number_format($this->amount, 2, '.', '').
                $this->getCurrency().
                strtoupper(md5(config('payhere.merchant_secret')))
            )
        );
    }

    private function getCurrency(): string
    {
        $currency = $this->currency ?? config('payhere.currency');

        if (! in_array($currency, ['LKR', 'USD', 'EUR', 'GBP', 'AUD'])) {
            throw new UnsupportedCurrencyException;
        }

        return $currency;
    }

    private function getOrderId(): string
    {
        if (! is_null($this->orderId)) {
            return $this->orderId;
        }
        
        return Str::uuid()->toString();
    }

    private function getItems(): string|array
    {
        if (! is_null($this->title)) {
            return $this->title;
        }

        if (sizeof($this->items) !== 0) {
            return $this->items;
        }

        return ['items' => 'Laravel'];
    }
}

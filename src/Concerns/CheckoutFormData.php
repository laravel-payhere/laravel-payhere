<?php

declare(strict_types=1);

namespace LaravelPayHere\Concerns;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use LaravelPayHere\Exceptions\UnsupportedCurrencyException;
use LaravelPayHere\Models\Contracts\PayHereCustomer;
use LaravelPayHere\PayHere;

trait CheckoutFormData
{
    /**
     * Recurring payment details.
     * 
     * @var array|null
     */
    private ?array $recurring = null;

    /**
     * Indicates if preapproval is required.
     * 
     * @var bool
     */
    private bool $preapproval = false;

    /**
     * Indicates if authorization is required.
     */
    private bool $authorize = false;

    /**
     * Platform information.
     * 
     * @var string|null
     */
    private ?string $platform = null;

    /**
     * Startup fee amount.
     * 
     * @var float|null
     */
    private ?float $startupFee = null;

    /**
     * Custom data for the checkout form.
     * 
     * @var array|null
     */
    private ?array $customData = null;

    /**
     * Item name.
     * 
     * @var string|null
     */
    private ?string $item = null;

    /**
     * The title of the transaction.
     * 
     * @var string|null
     */
    private ?string $title = null;

    /**
     * Items
     * 
     * @var array|null
     */
    private ?array $items = [];

    /**
     * The currency code for the transaction.
     * 
     * @var string|null
     */
    private ?string $currency = null;

    /**
     * The order id for the transaction.
     * 
     * @var string|null
     */
    private ?string $orderId = null;

    /**
     * The amount of the transaction.
     * 
     * @var float|null
     */
    private ?float $amount = null;

    /**
     * Indicates if the user is a guest.
     * 
     * @var bool
     */
    private bool $guest = false;

    /**
     * Get the form data for the checkout.
     *
     * @return array
     *
     * @throws \LaravelPayHere\Exceptions\UnsupportedCurrencyException
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
     * Set the user as a guest.
     * 
     * @return $this
     */
    public function guest(): static
    {
        $this->guest = true;
        
        return $this;
    }

    /**
     * Get the customer details for the transaction.
     *
     * @param $user
     * @return array
     * @throws \Exception
     */
    private function customer($user = null): array
    {
        if ($this->guest) {
            return [
                'first_name' => null,
                'last_name' => null,
                'email' => null,
                'phone' => null,
                'address' => null,
                'city' => null,
                'country' => null,
            ];
        }
        
        if (is_null($user)) {
            $user = Auth::user();
        }

        if (! $user instanceof PayHereCustomer) {
            throw new Exception('The '.PayHere::$customerModel.' class must be implement the LaravelPayHere\Models\Contracts\PayHereCustomer interface');
        }

        return [
            'first_name' => $user->payhereFirstName(),
            'last_name' => $user->payhereLastName(),
            'email' => $user->payhereEmail(),
            'phone' => $user->payherePhone(),
            'address' => $user->payhereAddress(),
            'city' => $user->payhereCity(),
            'country' => $user->payhereCountry(),
        ];
    }

    /**
     * Get item details for the form.
     *
     * @param  array  $items
     * @return string|array
     */
    private function items(array $items): string|array
    {
        return $items;
    }

    /**
     * Set the title of the transaction.
     *
     * @param string $title
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    private function title(string $title): static
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * Get other necessary details for the form.
     *
     * @return array
     *
     * @throws \LaravelPayHere\Exceptions\UnsupportedCurrencyException
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
     *
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function preapproval(): static
    {
        $this->preapproval = true;

        return $this;
    }

    /**
     * Set authorization for the payment.
     *
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function authorize(): static
    {
        $this->authorize = true;

        return $this;
    }

    /**
     * Generate the action URL for the form.
     *
     * @return string
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
     *
     * @param  string  $recurrence
     * @param  string  $duration
     * @return \LaravelPayHere\Concerns\CheckoutFormData
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
     *
     * @param  string  $platform
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function platform(string $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Set the startup fee for the form.
     *
     * @param  float  $fee
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function startupFee(float $fee): static
    {
        $this->startupFee = $fee;

        return $this;
    }

    /**
     * Set the startup fee for the form.
     *
     * @param  string  $id
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function orderId(string $id): static
    {
        $this->orderId = $id;

        return $this;
    }

    /**
     * Set custom data for the form.
     *
     * @param  string  ...$data
     * @return \LaravelPayHere\Concerns\CheckoutFormData
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
     *
     * @param  string  $item
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function item(string $item): static
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Set the name of currency for the transaction.
     *
     * @param  string  $currency
     * @return \LaravelPayHere\Concerns\CheckoutFormData
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the amount of currency for the transaction.
     * 
     * @param float $amount
     * @return \LaravelPayHere\Concerns\CheckoutFormData
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
     * 
     * @return string
     * @throws \LaravelPayHere\Exceptions\UnsupportedCurrencyException
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

    /**
     * Get the currency of the order.
     *
     * @return string
     *
     * @throws \LaravelPayHere\Exceptions\UnsupportedCurrencyException
     */
    private function getCurrency(): string
    {
        $currency = $this->currency ?? config('payhere.currency');

        if (! in_array($currency, ['LKR', 'USD', 'EUR', 'GBP', 'AUD'])) {
            throw new UnsupportedCurrencyException;
        }

        return $currency;
    }

    /**
     * Get the ID of the order.
     *
     * @return string
     */
    private function getOrderId(): string
    {
        if (! is_null($this->orderId)) {
            return $this->orderId;
        }

        $this->orderId = (string) rand();

        return $this->orderId;
    }

    /**
     * Get the items of the order.
     *
     * @return string|array
     */
    private function getItems(): string|array
    {
        if (count($this->items) !== 0) {
            return $this->items;
        }

        return ['items' => ! is_null($this->title) ? $this->title : null];
    }
}

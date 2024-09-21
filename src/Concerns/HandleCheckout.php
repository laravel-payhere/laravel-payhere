<?php

declare(strict_types=1);

namespace PayHere\Concerns;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use PayHere\Exceptions\UnsupportedCurrencyException;
use PayHere\Models\Contracts\PayHereCustomer;
use PayHere\Models\Subscription;
use PayHere\PayHere;

trait HandleCheckout
{
    /**
     * The PayHere customer.
     *
     * @var \Illuminate\Database\Eloquent\Model|null
     */
    private ?Model $customer = null;

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
    private bool $preapprove = false;

    /**
     * Indicates if authorization is required.
     */
    private bool $authorize = false;

    /**
     * Startup fee amount.
     *
     * @var float|null
     */
    private ?float $startupFee = null;

    /**
     * The title of the transaction.
     *
     * @var string|null
     */
    private ?string $title = null;

    /**
     * The items associated with the transaction.
     *
     * @var array
     */
    private array $items = [];

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
     * The date when the trial period ends.
     */
    private ?string $trialEndsAt = null;

    /**
     * The 1st custom parameter.
     *
     * @var string|null
     */
    private ?string $custom1 = null;

    /**
     * The 2nd custom parameter.
     *
     * @var string|null
     */
    private ?string $custom2 = null;

    /**
     * Set the customer for the transaction.
     *
     * @return $this
     */
    public function customer($customer): static
    {
        $this->customer = $customer;

        return $this;
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
     * Get item details for the form.
     *
     * @param  array  $items
     * @return static
     */
    public function items(array $items): static
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Set the title of the transaction.
     *
     * @param  string  $title
     * @return static
     */
    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set preapproval for the payment.
     *
     * @return static
     */
    public function preapprove(): static
    {
        $this->preapprove = true;

        return $this;
    }

    /**
     * Set authorization for the payment.
     *
     * @return static
     */
    public function authorize(): static
    {
        $this->authorize = true;

        return $this;
    }

    /**
     * Set recurring payment details.
     *
     * @param  string  $recurrence
     * @param  string  $duration
     * @return static
     */
    public function recurring(string $recurrence, string $duration): static
    {
        $this->recurring = [
            'recurrence' => $recurrence,
            'duration' => $duration,
        ];

        $subscription = Subscription::create([
            'order_id' => $this->getOrderId(),
            'ends_at' => now()->add($duration),
            'trial_ends_at' => $this->trialEndsAt,
        ]);

        $this->custom2 = (string) $subscription->getKey();

        return $this;
    }

    /**
     * Set the startup fee for the form.
     *
     * @param  float  $fee
     * @return static
     */
    public function startupFee(float $fee): static
    {
        $this->startupFee = $fee;

        return $this;
    }

    /**
     * Set the startup fee for the form.
     *
     * @param  string  $orderId
     * @return static
     */
    public function orderId(string $orderId): static
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Set the name of currency for the transaction.
     *
     * @param  string  $currency
     * @return static
     */
    public function currency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Set the amount of currency for the transaction.
     *
     * @param  float  $amount
     * @return static
     */
    public function amount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set the trial period in days.
     *
     * @param  int  $trialDays
     * @return static
     */
    public function trialDays(int $trialDays): static
    {
        $this->trialEndsAt = now()->addDays($trialDays)->toDateTimeString();

        return $this;
    }

    /**
     * Get the currency of the order.
     *
     * @return string
     *
     * @throws \PayHere\Exceptions\UnsupportedCurrencyException
     */
    private function getCurrency(): string
    {
        $currency = $this->currency ?? config('payhere.currency');

        if (! in_array($currency, PayHere::SUPPORTED_CURRENCIES)) {
            throw new UnsupportedCurrencyException;
        }

        return $currency;
    }

    /**
     * Get the id of the order.
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
     * Get the items for the transaction.
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getItems(): array
    {
        return $this->items;
    }

    /**
     * Get the title for the transaction.
     *
     * @return string
     */
    private function getTitle(): string
    {
        if (is_null($this->title)) {
            return __('Order #:id', ['id' => $this->getOrderId()]);
        }
        
        return $this->title;
    }

    /**
     * Get the customer details for the transaction.
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getCustomer(): array
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

        $user = $this->customer ?? Auth::user();

        if (! $user instanceof PayHereCustomer) {
            throw new Exception('The '.PayHere::$customerModel.' class must be implement the PayHere\Models\Contracts\PayHereCustomer interface');
        }

        $this->custom1 = (string) $user->getKey();

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
     * Generate the action URL for the form.
     *
     * @return string
     */
    private function getActionUrl(): string
    {
        $baseUrl = config('payhere.base_url');
        $action = 'checkout';

        if ($this->preapprove) {
            $action = 'preapprove';
        }

        if ($this->authorize) {
            $action = 'authorize';
        }

        return "$baseUrl/pay/$action";
    }

    /**
     * Generate a hash string.
     *
     * The hash value is required starting from 2023-01-16.
     *
     * @return string
     *
     * @throws \PayHere\Exceptions\UnsupportedCurrencyException
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
     * Get the form data for the checkout.
     *
     * @return array
     *
     * @throws \PayHere\Exceptions\UnsupportedCurrencyException
     */
    public function getFormData(): array
    {
        return [
            'title' => $this->getTitle(),
            'customer' => $this->getCustomer(),
            'items' => $this->getItems(),
            'action' => $this->getActionUrl(),
            'merchant_id' => config('payhere.merchant_id'),
            'notify_url' => config('payhere.notify_url') ?? URL::signedRoute('payhere.webhook'),
            'return_url' => config('payhere.return_url') ?? URL::signedRoute('payhere.return'),
            'cancel_url' => config('payhere.cancel_url') ?? url('/'),
            'order_id' => $this->getOrderId(),
            'currency' => $this->getCurrency(),
            'amount' => $this->amount - $this->startupFee,
            'hash' => $this->generateHash(),
            'recurring' => $this->recurring,
            'startup_fee' => $this->startupFee,
            'custom_1' => $this->custom1,
            'custom_2' => $this->custom2,
            'platform' => 'Laravel',
        ];
    }

    /**
     * Initiate the checkout process.
     *
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \PayHere\Exceptions\UnsupportedCurrencyException
     */
    public function checkout(): View
    {
        return view('payhere::checkout', [
            'data' => $this->getFormData(),
        ]);
    }
}

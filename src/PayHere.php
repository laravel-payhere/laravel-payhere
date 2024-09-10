<?php

declare(strict_types=1);

namespace PayHere;

use PayHere\Concerns\HandleCheckout;
use PayHere\Enums\PaymentStatus;
use PayHere\Models\Subscription;

class PayHere
{
    use HandleCheckout;

    const SUPPORTED_CURRENCIES = ['LKR', 'USD', 'EUR', 'GBP', 'AUD'];

    /**
     * The default customer model class name.
     */
    public static string $customerModel = 'App\\Models\\User';

    /**
     * The default subscription model class name.
     */
    public static string $subscriptionModel = Subscription::class;

    /**
     * Set the customer model class name.
     *
     * @param  $customerModel
     */
    public static function useCustomerModel($customerModel): void
    {
        static::$customerModel = $customerModel;
    }

    /**
     * Set the subscription model class name.
     *
     * @param  $subscriptionModel
     */
    public static function useSubscriptionModel($subscriptionModel): void
    {
        static::$subscriptionModel = $subscriptionModel;
    }

    /**
     * Verify the payment notification.
     */
    public static function verifyPaymentNotification(
        string $orderId,
        float $amount,
        string $currency,
        int $statusCode,
        string $md5sig
    ): bool {
        $localMd5Sig = strtoupper(
            md5(
                config('payhere.merchant_id').
                $orderId.
                number_format($amount, 2, '.', '').
                $currency.
                $statusCode.
                strtoupper(md5(config('payhere.merchant_secret')))
            )
        );

        return $localMd5Sig === $md5sig && ($statusCode === PaymentStatus::Success->value || $statusCode === PaymentStatus::AuthorizationSuccess->value);
    }

    /**
     * Verify if the provided merchant ID matches the configured PayHere merchant ID.
     *
     * @param  string  $merchantId
     * @return bool
     */
    public static function verifyMerchantId(string $merchantId): bool
    {
        return config('payhere.merchant_id') === $merchantId;
    }

    /**
     * Return a new static instance.
     *
     * @return static
     */
    public static function builder(): static
    {
        return new static;
    }
}

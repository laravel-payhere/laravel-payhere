<?php

declare(strict_types=1);

namespace LaravelPayHere;

use LaravelPayHere\Concerns\HandleCheckout;
use LaravelPayHere\Enums\PaymentStatus;

class PayHere
{
    use HandleCheckout;

    /**
     * The default customer model class name.
     */
    public static string $customerModel = 'App\\Models\\User';

    /**
     * The default customer relationship name.
     */
    public static string $customerRelationship = 'user';

    /**
     * The default payment relationship name.
     */
    public static string $paymentRelationship = 'payment';

    /**
     * The default subscription relationship name.
     */
    public static string $subscriptionRelationship = 'subscription';

    /**
     * Set the customer model class name.
     */
    public static function useCustomerModel($customerModel): void
    {
        static::$customerModel = $customerModel;
    }
    
    /**
     * Set the customer relationship name.
     */
    public static function useCustomerRelationship(string $relationship): void
    {
        self::$customerRelationship = $relationship;
    }
    

    /**
     * Set the subscription relationship name.
     */
    public static function useSubscriptionRelationship(string $relationship): void
    {
        self::$subscriptionRelationship = $relationship;
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

        return $localMd5Sig === $md5sig && ($statusCode === PaymentStatus::SUCCESS->value || $statusCode === PaymentStatus::AUTHORIZATION_SUCCESS->value);
    }

    /**
     * Verify if the provided merchant ID matches the configured PayHere merchant ID.
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
    public static function new(): static
    {
        return new static;
    }
}

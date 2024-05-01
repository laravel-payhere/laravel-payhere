<?php

namespace Dasundev\PayHere;

use Dasundev\PayHere\Exceptions\MissingAppIdException;
use Dasundev\PayHere\Exceptions\MissingAppSecretException;

class PayHere
{
    /**
     * The default customer model class name.
     */
    public static string $customerModel = 'App\\Models\\User';

    /**
     * The default order model class name.
     */
    public static string $orderModel = 'App\\Models\\Order';

    /**
     * The default order lines relationship name.
     */
    public static string $orderLinesRelationship = 'lines';

    /**
     * The default customer relationship name.
     */
    public static string $customerRelationship = 'user';

    /**
     * Set the customer model class name.
     */
    public static function useCustomerModel($customerModel): void
    {
        static::$customerModel = $customerModel;
    }

    /**
     * Set the order lines relationship name.
     */
    public static function useOrderLinesRelationship(string $relationship): void
    {
        self::$orderLinesRelationship = $relationship;
    }

    /**
     * Set the customer relationship name.
     */
    public static function useCustomerRelationship(string $relationship): void
    {
        self::$customerRelationship = $relationship;
    }

    /**
     * Verify the payment notification.
     */
    public static function verifyPaymentNotification(
        string $orderId,
        float $amount,
        string $currency,
        string|int $statusCode,
        string $md5sig
    ): bool {
        $localMd5Sig = strtoupper(
            md5(
                config('payhere.merchant_id').
                $orderId.
                $amount.
                $currency.
                $statusCode.
                strtoupper(md5(config('payhere.merchant_secret')))
            )
        );

        return $localMd5Sig === $md5sig && (int) $statusCode === 2;
    }

    /**
     * Generates an authorization code for PayHere API.
     *
     * @throws MissingAppIdException
     * @throws MissingAppSecretException
     */
    public static function generateAuthorizeCode(): string
    {
        if (is_null($appId = config('payhere.app_id'))) {
            throw new MissingAppIdException;
        }

        if (is_null($appSecret = config('payhere.app_secret'))) {
            throw new MissingAppSecretException;
        }

        return "$appId:$appSecret";
    }
}

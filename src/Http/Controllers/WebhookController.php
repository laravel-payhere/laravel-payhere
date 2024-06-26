<?php

namespace Dasundev\PayHere\Http\Controllers;

use Dasundev\PayHere\Events\PaymentVerified;
use Dasundev\PayHere\Events\SubscriptionActivated;
use Dasundev\PayHere\Http\Requests\WebhookRequest;
use Dasundev\PayHere\Models\Payment;
use Dasundev\PayHere\PayHere;
use Dasundev\PayHere\Repositories\PaymentRepository;
use Dasundev\PayHere\Repositories\SubscriptionRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(
        private readonly PaymentRepository $paymentRepository,
        private readonly SubscriptionRepository $subscriptionRepository,
    ) {}

    /**
     * Handle incoming webhook notification from PayHere.
     */
    public function handleWebhook(WebhookRequest $request)
    {
        $orderId = $request->order_id;

        $verifiedPayment = PayHere::verifyPaymentNotification(
            orderId: $orderId,
            amount: $request->payhere_amount,
            currency: $request->payhere_currency,
            statusCode: $request->status_code,
            md5sig: $request->md5sig,
        );

        $merchantId = $request->merchant_id;

        $verifiedMerchant = PayHere::verifyMerchantId($merchantId);

        // Verify that both the payment and the merchant are validated before proceeding.
        if (! $verifiedPayment || ! $verifiedMerchant) {
            Log::error('[PayHere] Verification failed', [
                'verifiedPayment' => $verifiedPayment,
                'verifiedMerchant' => $verifiedMerchant,
            ]);

            return;
        }

        // Abort if order not found.
        if (! $order = PayHere::$orderModel::find($orderId)) {
            Log::warning('[PayHere] Order not found', ['orderId' => $orderId]);

            return;
        }

        $relationship = PayHere::$customerRelationship;

        $user = $order->{$relationship};

        $payment = $this->paymentRepository->createPayment($user, $request);

        event(new PaymentVerified($payment));

        if ($request->isRecurring()) {
            $subscription = $this->subscriptionRepository->activateSubscription($user, $request);
            event(new SubscriptionActivated($subscription));
        }
    }
}

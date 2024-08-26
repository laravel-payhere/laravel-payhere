<?php

namespace LaravelPayHere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use LaravelPayHere\Enums\SubscriptionStatus;
use LaravelPayHere\Events\PaymentVerified;
use LaravelPayHere\Events\SubscriptionActivated;
use LaravelPayHere\Events\SubscriptionRenewed;
use LaravelPayHere\Models\Payment;
use LaravelPayHere\Models\Subscription;
use LaravelPayHere\PayHere;

class WebhookController extends Controller
{
    /**
     * Handle incoming webhook notification from PayHere.
     */
    public function handleWebhook(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return;
        }

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
            Log::warning('[PayHere] Order not found', ['order_id' => $orderId]);

            return;
        }

        $relationship = PayHere::$customerRelationship;

        $user = $order->{$relationship};

        $payment = $this->createPayment($user, $request);

        event(new PaymentVerified($payment));

        if ($this->isRecurringPayment($request)) {
            $this->updateSubscription($user, $request);
        }
    }

    private function createPayment($user, Request $request): Payment
    {
        return Payment::create([
            'user_id' => $user?->id,
            'merchant_id' => $request->merchant_id,
            'order_id' => $request->order_id,
            'payment_id' => $request->payment_id,
            'authorization_token' => $request->authorization_token,
            'subscription_id' => $request->subscription_id,
            'payhere_amount' => $request->payhere_amount,
            'captured_amount' => $request->captured_amount,
            'payhere_currency' => $request->payhere_currency,
            'status_code' => $request->status_code,
            'md5sig' => $request->md5sig,
            'status_message' => $request->status_message,
            'method' => $request->input('method'),
            'card_holder_name' => $request->card_holder_name,
            'card_no' => $request->card_no,
            'card_expiry' => $request->card_expiry,
            'recurring' => $request->recurring,
            'message_type' => $request->message_type,
            'item_recurrence' => $request->item_recurrence,
            'item_duration' => $request->item_duration,
            'item_rec_status' => $request->item_rec_status,
            'item_rec_date_next' => $request->item_rec_date_next,
            'item_rec_install_paid' => $request->item_rec_install_paid,
            'customer_token' => $request->customer_token,
            'custom_1' => $request->custom_1,
            'custom_2' => $request->custom_2,
        ]);
    }

    public function updateSubscription($user, Request $request): void
    {
        $subscriptionId = $request->custom_1;

        if (! $subscription = Subscription::find($subscriptionId)) {
            Log::warning('[PayHere] Subscription not found', ['subscription_id' => $subscriptionId]);

            return;
        }

        $daysUntilNextRecurrence = now()->diffInDays($request->item_rec_date_next);

        $subscription->update([
            'user_id' => $user->id,
            'payhere_subscription_id' => $request->subscription_id,
            'ends_at' => now()->addDays($daysUntilNextRecurrence),
        ]);

        $subscription->refresh();

        match ((int) $request->item_rec_status) {
            SubscriptionStatus::Active->value => $subscription->markAsActive(),
            SubscriptionStatus::Cancelled->value => $subscription->markAsCancelled(),
            SubscriptionStatus::Completed->value => $subscription->markAsCompleted(),
        };

        if ($this->isNewSubscription($request)) {
            event(new SubscriptionActivated($subscription));
        } else {
            event(new SubscriptionRenewed($subscription));
        }
    }

    /**
     * Check if the payment is recurring.
     */
    private function isRecurringPayment($request)
    {
        return (int) $request->recurring === 1;
    }

    /**
     * Check if the subscription is new.
     */
    private function isNewSubscription($request): bool
    {
        return (int) $request->item_rec_install_paid === 1;
    }
}

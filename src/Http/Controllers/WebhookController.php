<?php

declare(strict_types=1);

namespace PayHere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use PayHere\Enums\SubscriptionStatus;
use PayHere\Events\PaymentVerified;
use PayHere\Models\Payment;
use PayHere\Models\Subscription;
use PayHere\PayHere;

class WebhookController extends Controller
{
    /**
     * Handle incoming webhook notification from PayHere.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function handleWebhook(Request $request)
    {
        // Validate the signature only if the application is in production.
        if (app()->isProduction()) {
            abort_unless($request->hasValidSignature(), 401);
        }

        $orderId = $request->order_id;

        $verifiedPayment = PayHere::verifyPaymentNotification(
            orderId: $orderId,
            amount: (float) $request->payhere_amount,
            currency: $request->payhere_currency,
            statusCode: (int) $request->status_code,
            md5sig: $request->md5sig,
        );

        $merchantId = $request->merchant_id;

        $verifiedMerchant = PayHere::verifyMerchantId($merchantId);

        // Verify the merchant is validated before proceeding.
        if (! $verifiedMerchant) {
            Log::error('PayHere merchant verification failed');

            return;
        }

        // Verify the payment is validated before proceeding.
        if (! $verifiedPayment) {
            Log::error('PayHere payment verification failed');

            return;
        }

        $payment = $this->createPayment($request);

        event(new PaymentVerified($payment));

        if ($this->isPaymentRecurring($request)) {
            $this->updateSubscription($request);
        }
    }

    /**
     * Create a new payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \PayHere\Models\Payment
     */
    private function createPayment(Request $request): Payment
    {
        return Payment::create([
            'user_id' => $request->custom_1,
            'merchant_id' => $request->merchant_id,
            'order_id' => $request->order_id,
            'payhere_payment_id' => $request->payment_id,
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

    /**
     * Update the subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function updateSubscription(Request $request): void
    {
        $userId = $request->custom_1;
        $subscriptionId = $request->custom_2;

        if (! $subscription = Subscription::find($subscriptionId)) {
            Log::error('PayHere subscription not found', ['subscription_id' => $subscriptionId]);

            return;
        }

        $subscription->update([
            'user_id' => $userId,
            'payhere_subscription_id' => $request->subscription_id,
        ]);

        $nextInstallmentDate = $request->item_rec_date_next;

        // If the PayHere webhook provides the 'item_rec_date_next' parameter,
        // calculate the number of days until the next recurring installment
        // and update the subscription's end date accordingly.
        if (! is_null($nextInstallmentDate)) {
            $daysUntilNextRecurrence = now()->diffInDays($nextInstallmentDate);

            $subscription->update([
                'ends_at' => now()->addDays($daysUntilNextRecurrence),
            ]);
        }

        $subscriptionStatus = (string) $request->item_rec_status;

        match ($subscriptionStatus) {
            SubscriptionStatus::Active->value => $subscription->markAsActive(),
            SubscriptionStatus::Cancelled->value => $subscription->markAsCancelled(),
            SubscriptionStatus::Completed->value => $subscription->markAsCompleted(),
        };
    }

    /**
     * Check if the payment is recurring.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function isPaymentRecurring(Request $request): bool
    {
        return $request->boolean('recurring');
    }
}

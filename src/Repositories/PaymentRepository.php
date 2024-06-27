<?php

namespace Dasundev\PayHere\Repositories;

use Dasundev\PayHere\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PaymentRepository
{
    /**
     * Create a payment record for the given user.
     */
    public function createPayment(?Model $user, Request $request): Payment
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
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payhere_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('order_id');
            $table->string('merchant_id');
            $table->string('payment_id')->unique()->nullable();
            $table->boolean('refunded')->default(false);
            $table->string('refund_reason')->nullable();
            $table->string('authorization_token')->nullable();
            $table->string('subscription_id')->nullable();
            $table->float('payhere_amount');
            $table->float('captured_amount')->nullable();
            $table->string('payhere_currency');
            $table->enum('status_code', [3, 2, 0, -1, -2, -3]);
            $table->string('md5sig');
            $table->string('status_message');
            $table->enum('method', [
                'VISA',
                'MASTER',
                'AMEX',
                'EZCASH',
                'MCASH',
                'GENIE',
                'VISHWA',
                'PAYAPP',
                'HNB',
                'FRIMI',
            ]);
            $table->string('card_holder_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('card_expiry')->nullable();
            $table->enum('recurring', [0, 1])->default(0);
            $table->enum('message_type', [
                'AUTHORIZATION_SUCCESS',
                'AUTHORIZATION_FAILED',
                'RECURRING_INSTALLMENT_SUCCESS',
                'RECURRING_INSTALLMENT_FAILED',
                'RECURRING_COMPLETE',
                'RECURRING_STOPPED',
            ])->nullable();
            $table->string('item_recurrence')->nullable();
            $table->string('item_duration')->nullable();
            $table->enum('item_rec_status', [0, -1, 1])->nullable();
            $table->date('item_rec_date_next')->nullable();
            $table->unsignedInteger('item_rec_install_paid')->nullable();
            $table->string('customer_token')->nullable();
            $table->string('custom_1')->nullable();
            $table->string('custom_2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

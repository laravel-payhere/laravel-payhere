<?php

declare(strict_types=1);

use PayHere\Http\Controllers\Api\PaymentController;
use PayHere\Http\Controllers\Api\SubscriptionController;

Route::group(['prefix' => 'payhere/api', 'as' => 'payhere.api.', 'middleware' => 'api'], function () {
    Route::get('payments/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('payments/charge', [PaymentController::class, 'charge'])->name('payment.charge');
    Route::post('payments/refund', [PaymentController::class, 'refund'])->name('payment.refund');
    Route::post('payments/capture', [PaymentController::class, 'capture'])->name('payment.capture');
    
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('subscriptions/{id}/payments', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('subscriptions/{id}/retry', [SubscriptionController::class, 'retry'])->name('subscription.retry');
    Route::delete('subscriptions/{id}', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

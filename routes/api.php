<?php

declare(strict_types=1);

use PayHere\Http\Controllers\Api\PaymentController;
use PayHere\Http\Controllers\Api\SubscriptionController;

Route::group(['prefix' => 'payhere/api', 'as' => 'payhere.api.'], function () {
    Route::prefix('payments')->as('payment.')->group(function () {
        Route::get('{id}', [PaymentController::class, 'show'])->name('show');
        Route::post('charge', [PaymentController::class, 'charge'])->name('charge');
        Route::post('refund', [PaymentController::class, 'refund'])->name('refund');
        Route::post('capture', [PaymentController::class, 'capture'])->name('capture');
    });
    Route::prefix('subscriptions')->as('subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::get('{id}', [SubscriptionController::class, 'show'])->name('show');
        Route::post('{id}/retry', [SubscriptionController::class, 'retry'])->name('retry');
        Route::delete('{id}', [SubscriptionController::class, 'cancel'])->name('cancel');
    });
});

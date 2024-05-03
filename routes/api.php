<?php

use Dasundev\PayHere\Http\Controllers\Api\ChargeController;
use Dasundev\PayHere\Http\Controllers\Api\RetrievalController;
use Dasundev\PayHere\Http\Controllers\Api\SubscriptionController;

Route::group(['prefix' => 'payhere/api', 'as' => 'payhere.api.'], function () {
    Route::post('/charge', ChargeController::class)->name('charge');
    Route::post('/retrieval', RetrievalController::class)->name('retrieval');
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
});

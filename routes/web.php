<?php

use Illuminate\Support\Facades\Route;
use LaravelPayHere\Http\Controllers\PayHereController;
use LaravelPayHere\Http\Controllers\WebhookController;

Route::group(['prefix' => 'payhere', 'as' => 'payhere.'], function () {
    Route::get('/return', [PayHereController::class, 'handleReturn'])->name('return');
    Route::post('/webhook', [WebhookController::class, 'handleWebhook'])->middleware('signed')->name('webhook');
});

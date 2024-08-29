<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use PayHere\Http\Controllers\PayHereController;
use PayHere\Http\Controllers\WebhookController;

Route::group(['prefix' => 'payhere', 'as' => 'payhere.'], function () {
    Route::get('/return', [PayHereController::class, 'handleReturn'])->name('return');
    Route::post('/webhook', [WebhookController::class, 'handleWebhook'])->middleware('signed')->name('webhook');
});

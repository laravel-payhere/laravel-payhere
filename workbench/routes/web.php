<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use PayHere\Http\Controllers\WebhookController;
use Workbench\App\Http\Controllers\Authorize;
use Workbench\App\Http\Controllers\Checkout;
use Workbench\App\Http\Controllers\Preapproval;
use Workbench\App\Http\Controllers\Recurring;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/checkout', Checkout::class)
    ->name('checkout');

Route::get('/preapproval', Preapproval::class)
    ->name('preapproval');

Route::get('/authorize', Authorize::class)
    ->name('authorize');

Route::get('/recurring', Recurring::class)
    ->name('recurring');

Route::post('/webhook', [WebhookController::class, 'handleWebhook'])
    ->withoutMiddleware(VerifyCsrfToken::class);

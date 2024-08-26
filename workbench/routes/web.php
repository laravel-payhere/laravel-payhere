<?php

use LaravelPayHere\Http\Controllers\WebhookController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
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
    ->middleware('auth')
    ->name('checkout');

Route::get('/preapproval', Preapproval::class)
    ->middleware('auth')
    ->name('preapproval');

Route::get('/authorize', Authorize::class)
    ->middleware('auth')
    ->name('authorize');

Route::get('/recurring', Recurring::class)
    ->middleware('auth')
    ->name('recurring');

Route::post('/webhook', [WebhookController::class, 'handleWebhook'])
    ->withoutMiddleware(VerifyCsrfToken::class);

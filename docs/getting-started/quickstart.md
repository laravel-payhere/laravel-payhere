---
title: Quickstart
weight: 2
---

# Quickstart

To begin your Laravel PayHere journey, we will create a simple checkout route and render it in the browser. This example is a great way to experience Laravel PayHere for the first time, as it demonstrates the plugin's power in the simplest way possible.

## Prerequisites

Before we start, make sure you have the following installed:

-   Laravel v10.0 or higher
-   Filament v3.0 or higher

## Installation via composer

From the root directory of your Laravel app, run the following [Composer](https://getcomposer.org/) command:

```bash
composer require laravel-payhere/laravel-payhere
```

Finally, you may run the following command to publish assets and migrations:

```bash
php artisan payhere:install
```

If you plan to use the PayHere panel, you should run the following command to publish the Filament assets:

```bash
php artisan filament:assets
```

## Configure PayHere API keys

Copy and paste following environment keys to your application's `.env` file, and replace them with your actual API keys.

```dotenv
PAYHERE_MERCHANT_ID=your-payhere-merchant-id
PAYHERE_MERCHANT_SECRET=-your-payhere-merchant-secret
PAYHERE_SANDBOX=true
```

_If you need help retrieving API keys, follow [this](../configuration/api-keys.md#retrieve-api-keys-from-payhere) guide._

## Create a controller

You can create a new controller to process the checkout. In this case, we are creating a [Single Action Controller](https://laravel.com/docs/11.x/controllers#single-action-controllers) using the following Artisan command:

```bash
php artisan make:controller Checkout --invokable
```

This command will generate a controller located at `app/Http/Controllers/Checkout.php`.

## Writing the controller

Open `app/Http/Controllers/Checkout.php` and replace it's content with the following:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use PayHere\PayHere;

class Checkout extends Controller
{
    public function __invoke()
    {
        return PayHere::order()
            ->amount(2500)
            ->checkout();
    }
}
```

## Register a route

Open the `routes/web.php` file in your Laravel application and add the following code:

```php
use App\Http\Controllers\Checkout;

Route::get('/checkout', Checkout::class);
```

## Test it out

Visit `/checkout` in your browser, and you should see a redirect page. You will then be redirected to the [PayHere](https://payhere.lk) payment gateway to complete the payment.

We've only scratched the surface of what Laravel PayHere can do. Keep reading the documentation to explore all that Laravel PayHere has to offer.

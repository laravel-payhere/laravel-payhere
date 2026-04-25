---
title: Examples
weight: 3
---

# Examples

## Normal Checkout

This example demonstrates how to process a recurring checkout.

```php
use PayHere\PayHere;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        return PayHere::order()
            ->guest()
            ->title('Perpetual License (1 Year)')
            ->amount(30000)
            ->checkout();
    }
}
```

## Recurring Checkout

This example demonstrates how to process a recurring checkout.

```php
use PayHere\PayHere;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        return PayHere::order()
            ->title('Shared Hosting')
            ->amount(1000)
            ->startupFee(200)
            ->recurring(
                 recurrence: '1 Month',
                 duration: '1 Year'
             )
            ->checkout();
    }
}
```

## Onsite Checkout

This example demonstrates how to process a onsite checkout.

First, add the following Blade component to your view:

```html
<x-payhere::button
    :order="PayHere\PayHere::order()->guest()->amount(100)->getOrder()"
    class="px-8 py-4"
>
    Buy Now
</x-payhere::button>
```

> [!IMPORTANT]
> We use the [HTML Form-Based API Builder](../builder/introduction.md) to create the order. Therefore, you are free to chain builder methods as you would for other checkouts.

After that, you can listen for PayHere events:

```javascript
// Payment completed. It can be a successful failure.
payhere.onCompleted = function onCompleted(orderId) {
    console.log("Payment completed. OrderID:" + orderId);
    // Note: validate the payment and show success or failure page to the customer
};

// Payment window closed
payhere.onDismissed = function onDismissed() {
    // Note: Prompt user to pay again or show an error page
    console.log("Payment dismissed");
};

// Error occurred
payhere.onError = function onError(error) {
    // Note: show an error page
    console.log("Error:" + error);
};
```

For more details, visit the PayHere [Javascript SDK](https://support.payhere.lk/api-&-mobile-sdk/javascript-sdk).

---
title: Builder Methods
weight: 2
---

# Builder Methods

To start using builder methods, you first need to create a builder instance:

```php
use PayHere\PayHere;

$builder = PayHere::order();
```

---

##### `guest()`

The `guest` method set the transaction as a guest.

```php
$builder->guest();
```

---

##### `title()`

The `title` method set the order title for the transaction.

```php
$builder->title('Taxi Hire');
```

---

##### `recurring()`

The `recurring` method set the transaction as a recurring payment. You can specify the `recurrence` period (e.g., 6 Month, 1 Year) and the `duration` to charge (e.g., 1 Year, Forever).

```php
$builder->recurring(recurrence: '1 Month', duration: '1 Year');
```

---

##### `startupFee()`

The `startupFee` method sets an additional fee or discount for the first payment occurrence in a recurring payment.

```php
$builder->startupFee(1000);
```

---

##### `authorize()`

The `authorize` method set the transaction as an authorize payment.

```php
$builder->authorize();
```

---

##### `preapprove()`

The `preapprove` method set the transaction as a pre-approved payment.

```php
$builder->preapprove();
```

---

##### `amount()`

The `amount` method set the amount for the transaction.

```php
$builder->amount(100);
```

---

##### `checkout()`

The `checkout` method redirects customer to the payment gateway.

```php
$builder->checkout();
```

_You must call this method at the end of builder method chain._

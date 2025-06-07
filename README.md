<p align="center">
    <img src="./art/logo.svg" alt="PayHere" width="400"/>
</p>

<p align="center">
    <a href="https://github.com/laravel-payhere/laravel-payhere/actions"><img src="https://img.shields.io/github/actions/workflow/status/laravel-payhere/laravel-payhere/tests.yml?label=tests" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel-payhere/laravel-payhere"><img src="https://img.shields.io/packagist/dt/laravel-payhere/laravel-payhere" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel-payhere/laravel-payhere"><img src="https://img.shields.io/packagist/v/laravel-payhere/laravel-payhere" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel-payhere/laravel-payhere"><img src="https://img.shields.io/github/license/laravel-payhere/laravel-payhere" alt="License"></a>
</p>

## Introduction

Easily and securely integrate [PayHere](https://payhere.lk) into your Laravel application.

```php
// A super simple example to show how easy it is to integrate PayHere!

use PayHere\PayHere;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        return PayHere::builder()
            ->title('iPhone 16 Pro')
            ->amount(329900)
            ->checkout();
    }
}
```

## Official Documentation

You can find the documentation [here](https://www.dasun.dev/docs/laravel-payhere).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](SECURITY.md) on how to report security vulnerabilities.

## License

The Laravel PayHere is open-sourced software licensed under the [MIT license](LICENSE.md).

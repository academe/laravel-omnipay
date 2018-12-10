Omnipay for Laravel 5 & Lumen
==============

[![Total Downloads](https://img.shields.io/packagist/dt/ignited/laravel-omnipay.svg)](https://packagist.org/packages/ignited/laravel-omnipay)
[![Latest Version](http://img.shields.io/packagist/v/ignited/laravel-omnipay.svg)](https://github.com/ignited/laravel-omnipay/releases)
[![Dependency Status](https://www.versioneye.com/php/ignited:laravel-omnipay/badge.svg)](https://www.versioneye.com/php/ignited:laravel-omnipay)

Integrates the [Omnipay](https://github.com/adrianmacneil/omnipay) PHP library with Laravel 5.6 via a ServiceProvider to make Configuring multiple payment tunnels a breeze!

### Now using Omnipay 3.0
 
* Version `2.0` and onwards has been updated to use Omnipay 3.0.
* Version `2.2` and onwards is using Omnipay 2.5
* Version `2.3` and onwards supports Laravel 5.4

### Composer Configuration

Include the laravel-omnipay package as a dependency in your `composer.json`:

    "academe/laravel-omnipay": "3.*"

**Note:** You don't need to include the `omnipay/common` in your composer.json - it is a requirement of the `laravel-omnipay` package.

Each gateway driver is a seperate package.
The `omnipay/common` package includes the core framework.
You will then need to include each gateway as you require.
Example:

    "omnipay/eway": "3.*"

For Omnipay 3.x you will also need a HTTP client and a bridge.
For example to use Guzzle, require these two packages
(later versions are likely to be supported):

    "guzzlehttp/guzzle": "^6.3"
    "php-http/guzzle6-adapter": "~1.1"

### Installation

Run `composer install` to download the dependencies.

#### Laravel 5

**Note:** From Laravel 5.6, the following steps are automated through the discovery feature,
so you will not need to add the provider and facade entries manually.

Add a ServiceProvider to your providers array in `config/app.php`:

```php
'providers' => [
    ...
    Academe\LaravelOmnipay\LaravelOmnipayServiceProvider::class,
];
```

Add the `Omnipay` facade to your facades array:

```php
'aliases' => [
    ...
    'Omnipay' => Academe\LaravelOmnipay\Facades\OmnipayFacade::class,
];
```

Finally, publish the configuration files:

```
php artisan vendor:publish --provider="Academe\LaravelOmnipay\LaravelOmnipayServiceProvider" --tag=config
```

#### Lumen

For `Lumen` add the following in your bootstrap/app.php
```php
$app->register(Academe\LaravelOmnipay\LumenOmnipayServiceProvider::class);
```

Copy the `laravel-omnipay.php` file from the config directory to `config/laravel-omnipay.php`

Also add the following to `bootstrap/app.php`:

```php
$app->configure('laravel-omnipay');
```

### Configuration

Once you have published the configuration files, you can add your gateway options to the config file in `config/laravel-omnipay.php`.

#### PayPal Express Example

Here is an example of how to configure password, username and, signature with paypal express checkout driver

```php
...
'gateways' => [
    'paypal' => [
        'driver'  => 'PayPal_Express',
        'options' => [
            'username'          => env('OMNIPAY_PAYPAL_EXPRESS_USERNAME'),
            'password'          => env('OMNIPAY_PAYPAL_EXPRESS_PASSWORD'),
            'signature'         => env('OMNIPAY_PAYPAL_EXPRESS_SIGNATURE'),
            'solutionType'      => env('OMNIPAY_PAYPAL_EXPRESS_SOLUTION_TYPE'),
            'landingPage'       => env('OMNIPAY_PAYPAL_EXPRESS_LANDING_PAGE'),
            'headerImageUrl'    => env('OMNIPAY_PAYPAL_EXPRESS_HEADER_IMAGE_URL'),
            'brandName'         => 'Your app name',
            'testMode'          => env('OMNIPAY_PAYPAL_TEST_MODE', true)
        ]
    ],
]
...
```

### Usage

```php
$cardInput = [
    'number'      => '4444333322221111',
    'firstName'   => 'MR. WALTER WHITE',
    'expiryMonth' => '03',
    'expiryYear'  => '16',
    'cvv'         => '333',
];

$card = Omnipay::creditCard($cardInput);
$response = Omnipay::purchase([
    'amount'    => '100.00',
    'returnUrl' => 'http://example.com/payment/return',
    'cancelUrl' => 'http://example.com/payment/cancel',
    'card'      => $cardInput
])->send();

dd($response->getMessage());
```

This will use the gateway specified in the config as `default`.

You can explicitly specify a gateway to use:

```php
// Alias for \Academe\LaravelOmnipay\Facades\OmnipayFacade

use Omnipay;

Omnipay::setGateway('eway');

$response = Omnipay::purchase([
    'amount' => '100.00',
    'card'   => $cardInput
])->send();

dd($response->getMessage());
```

In addition you can take an instance of the gateway.

```php
$gateway = Omnipay::gateway('eway');
```

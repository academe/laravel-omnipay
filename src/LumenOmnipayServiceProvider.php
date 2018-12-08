<?php

namespace Academe\LaravelOmnipay;

class LumenOmnipayServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__ . '/../config/laravel-omnipay.php'),
            'laravel-omnipay'
        );
    }
}

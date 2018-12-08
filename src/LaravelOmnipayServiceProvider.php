<?php

namespace Academe\LaravelOmnipay;

class LaravelOmnipayServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // Publish config

        $configPath = __DIR__ . '/../config/laravel-omnipay.php';

        $this->publishes(
            [$configPath => config_path('laravel-omnipay.php')],
            'config'
        );
    }
}

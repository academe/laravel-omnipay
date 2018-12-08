<?php

namespace Academe\LaravelOmnipay\Facades;

use Illuminate\Support\Facades\Facade;
use Academe\LaravelOmnipay\BaseServiceProvider;

class OmnipayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BaseServiceProvider::PROVIDES;
    }
}

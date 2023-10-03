<?php

namespace Timedoor\LaravelFilter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Timedoor\LaravelFilter\LaravelFilter
 */
class LaravelFilter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Timedoor\LaravelFilter\LaravelFilter::class;
    }
}

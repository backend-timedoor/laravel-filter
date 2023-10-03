<?php

namespace Timedoor\LaravelFilter\Concerns;

use Timedoor\LaravelFilter\LaravelFilterQueryBuilder;

trait Filterable
{
    public function newEloquentBuilder($query)
    {
        return new LaravelFilterQueryBuilder($query);
    }
}

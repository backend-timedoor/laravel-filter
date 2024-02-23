<?php

namespace Timedoor\LaravelFilter\Concerns;

use Illuminate\Http\Request;
use stdClass;
use Timedoor\LaravelFilter\LaravelFilterQueryBuilder;

trait Filterable
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new LaravelFilterQueryBuilder($query);
    }

    /**
     * @param  stdClass  $subject
     * @param  array<string, mixed>  $options
     * @return \Timedoor\LaravelFilter\LaravelFilterQueryBuilder
     */
    public static function applyFilter($subject, $options = [], ?Request $request = null)
    {
        /** @var \Timedoor\LaravelFilter\LaravelFilterQueryBuilder $builder */
        $builder = (new static)->newQuery();

        return $builder->applyFilter($subject, $options, $request);
    }
}

<?php

namespace Timedoor\LaravelFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use stdClass;

class LaravelFilterQueryBuilder extends Builder
{
    /**
     * @param  stdClass  $subject
     * @param  array<string, mixed>  $options
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function applyFilter($subject, $options = [], Request $request = null)
    {
        return LaravelFilter::create($subject, $options, $request)->apply($this);
    }
}

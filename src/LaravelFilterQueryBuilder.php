<?php

namespace Timedoor\LaravelFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use stdClass;

class LaravelFilterQueryBuilder extends Builder
{
    /**
     * @param  stdClass  $subject
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyFilter($subject, Request $request = null)
    {
        return LaravelFilter::create($subject, $request)->apply($this);
    }
}

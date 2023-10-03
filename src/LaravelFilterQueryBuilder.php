<?php

namespace Timedoor\LaravelFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use stdClass;

class LaravelFilterQueryBuilder extends Builder
{
    /**
     * @param stdClass $subject
     * @param \Illuminate\Http\Request|null $request
     * @return static
     */
    public function applyFilter($subject, ?Request $request = null): static
    {
        return LaravelFilter::create($subject, $request)->apply($this);
    }
}

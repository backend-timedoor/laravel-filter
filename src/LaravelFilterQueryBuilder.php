<?php

namespace Timedoor\LaravelFilter;

use Illuminate\Database\Eloquent\Builder;

class LaravelFilterQueryBuilder extends Builder
{
    /**
     * @param \Timedoor\LaravelFilter\LaravelFilter $subject
     * @return static
     */
    public function apply($subject)
    {
        return $subject->apply($this);
    }
}

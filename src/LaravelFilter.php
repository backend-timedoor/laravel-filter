<?php

namespace Timedoor\LaravelFilter;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use stdClass;

final class LaravelFilter
{
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var stdClass
     */
    protected $subject;

    /**
     * @param  stdClass  $subject
     * @return \Timedoor\LaravelFilter\LaravelFilter
     */
    public static function create($subject, Request $request = null)
    {
        return new self($subject, $request);
    }

    /**
     * @param  stdClass  $subject
     */
    public function __construct($subject, Request $request = null)
    {
        $request = $request ?? request();

        $this->initializeFilters($request)
            ->initializeSubject($subject);
    }

    protected function initializeFilters(Request $request): static
    {
        $this->filters = $request->all();

        return $this;
    }

    protected function initializeSubject($subject): static
    {
        $this->subject = $subject instanceof stdClass
            ? $subject
            : new $subject;

        return $this;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $query)
    {
        $subject = $this->subject;

        foreach ($this->filters as $filterName => $value) {
            if (empty($value)) {
                continue;
            }

            $name = Str::camel($filterName);

            if (! method_exists($subject, $name)) {
                continue;
            }

            $query = $subject->$name($query, $value);
        }

        return $query;
    }
}

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
     * @param  array<string, mixed>  $options
     * @return \Timedoor\LaravelFilter\LaravelFilter
     */
    public static function create($subject, $options, ?Request $request = null)
    {
        return new self($subject, $options, $request);
    }

    /**
     * @param  stdClass  $subject
     * @param  array<string, mixed>  $options
     */
    public function __construct($subject, $options, ?Request $request = null)
    {
        $request = $request ?? request();

        $this->initializeFilters($request)
            ->initializeSubject($subject)
            ->initializeOptions($options);
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

    protected function initializeOptions(array $options): static
    {
        if (empty($options)) {
            return $this;
        }

        if (array_key_exists('include', $options)) {
            foreach ($options['include'] as $key => $value) {
                if (empty($value)) {
                    continue;
                }

                if (array_key_exists($key, $this->filters) && ! empty($this->filters[$key])) {
                    continue;
                }

                $this->filters[$key] = $value;
            }
        }

        if (array_key_exists('exclude', $options)) {
            foreach ($options['exclude'] as $exclude) {
                if (empty($exclude)) {
                    continue;
                }

                if (! array_key_exists($exclude, $this->filters)) {
                    continue;
                }

                unset($this->filters[$exclude]);
            }
        }

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
            if (is_array($value) && empty($value)) {
                continue;
            }

            if (! isset($value)) {
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

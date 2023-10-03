<?php

namespace Timedoor\LaravelFilter\Tests\TestClasses\Models;

use Illuminate\Database\Eloquent\Model;
use Timedoor\LaravelFilter\Concerns\Filterable;

class TestModel extends Model
{
    use Filterable;

    protected $guarded = [];
}

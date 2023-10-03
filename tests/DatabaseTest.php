<?php

use Timedoor\LaravelFilter\Tests\TestClasses\Models\TestModel;

it('can get all data test', function () {
    $data = TestModel::all();

    expect($data)->toHaveCount(10);
});

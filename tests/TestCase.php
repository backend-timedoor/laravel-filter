<?php

namespace Timedoor\LaravelFilter\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Timedoor\LaravelFilter\LaravelFilterServiceProvider;
use Timedoor\LaravelFilter\Tests\TestClasses\Models\TestModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Application;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);

        $this->insertData();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Timedoor\\LaravelFilter\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelFilterServiceProvider::class,
        ];
    }

    protected function setUpDatabase(Application $app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('age');
            $table->timestamps();
        });
    }

    protected function insertData()
    {
        $data = [
            [
                'name' => "Rizky Hidayattulloh",
                'age' => 20
            ],
            [
                'name' => "Nur Hidayattulloh",
                'age' => 21
            ],
            [
                'name' => "Rizky Nur",
                'age' => 25
            ],
            [
                'name' => "John Doe",
                'age' => 30
            ],
            [
                'name' => "Asep Sutisna",
                'age' => 18
            ],
            [
                'name' => "Komar Maulana",
                'age' => 22
            ],
            [
                'name' => "Maya Sitha",
                'age' => 22
            ],
            [
                'name' => "Sudharmono Kusuma",
                'age' => 35
            ],
            [
                'name' => "Muhammad Rizky",
                'age' => 25
            ],
            [
                'name' => "Muhammad Ibnu",
                'age' => 26
            ],
        ];

        TestModel::insert($data);
    }
}

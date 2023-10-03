<?php

namespace Timedoor\LaravelFilter\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeFilterCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new filter class';

     /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    protected function getStub()
    {
        return __DIR__ . '/stubs/filter.php.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return is_dir(app_path()) ? $rootNamespace.'\\Http\\Filters' : $rootNamespace;
    }

    public function handle()
    {
        parent::handle();
    }
}

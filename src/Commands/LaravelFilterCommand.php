<?php

namespace Timedoor\LaravelFilter\Commands;

use Illuminate\Console\Command;

class LaravelFilterCommand extends Command
{
    public $signature = 'laravel-filter';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

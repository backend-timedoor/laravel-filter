<?php

namespace Timedoor\LaravelFilter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Timedoor\LaravelFilter\Commands\LaravelFilterCommand;

class LaravelFilterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-filter')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-filter_table')
            ->hasCommand(LaravelFilterCommand::class);
    }
}

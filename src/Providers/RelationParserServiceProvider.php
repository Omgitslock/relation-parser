<?php

namespace Omgitslock\RelationParser\Providers;

use Illuminate\Support\ServiceProvider;

use Omgitslock\RelationParser\Drivers\FileDriver;
use Omgitslock\RelationParser\Contracts\DriverInterface;
use Omgitslock\RelationParser\Contracts\FilterInterface;
use Omgitslock\RelationParser\Services\EloquentMethodFilterService;

class RelationParserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(
            DriverInterface::class,
            FileDriver::class
        );

        $this->app->bind(
            FilterInterface::class,
            EloquentMethodFilterService::class
        );
    }
}
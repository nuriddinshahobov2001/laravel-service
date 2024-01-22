<?php

namespace Zintel\LaravelService\Providers;

use Illuminate\Support\ServiceProvider;
use Zintel\LaravelService\Console\Commands\MakeServiceCommand;

class PostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
               MakeServiceCommand::class
            ]);
        }
    }
}

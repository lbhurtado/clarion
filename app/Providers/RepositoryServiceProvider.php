<?php

namespace Clarion\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Clarion\Domain\Contracts\UserRepository::class, \Clarion\Infrastructure\EloquentRepositories\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
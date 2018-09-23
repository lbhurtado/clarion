<?php

namespace Clarion\Providers;

use Clarion\Domain\Models\User;
use Clarion\Domain\Models\Mobile;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::creating(function ($model) {
            $model->mobile = Mobile::number($model->mobile);
            $model->handle = $model->handle ?: $model->mobile;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

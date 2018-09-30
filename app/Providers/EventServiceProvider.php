<?php

namespace Clarion\Providers;

use Clarion\Domain\Events as Events;
use Illuminate\Support\Facades\Event;
use Clarion\Domain\Listeners as Listeners;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Events\UserWasRecorded::class => [
            Listeners\Capture\UserMobileData::class,
        ],
        // Events\UserWasRegistered::class => [
        //     Listeners\Notify\UserAboutVerification::class,
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

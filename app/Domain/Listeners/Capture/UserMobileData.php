<?php

namespace Clarion\Domain\Listeners\Capture;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMobileData
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(\Clarion\Domain\Events\UserRecorded $event)
    {
        \Clarion\Domain\Jobs\RegisterAuthyService::dispatch($event->user);
    }
}

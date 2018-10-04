<?php

namespace Clarion\Domain\Listeners\Notify;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAboutVerification
{
    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle($event)
    {
        \Clarion\Domain\Jobs\RequestOTP::dispatch($event->user);
    }
}

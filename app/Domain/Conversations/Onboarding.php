<?php

namespace Clarion\Domain\Conversations;


use BotMan\BotMan\Messages\Conversations\Conversation;

class Onboarding extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->provideGreeting();
    }

    protected function provideGreeting()
    {
        $this->bot->reply(trans('onboarding.welcome', ['name' => config('app.name')]));
        sleep(2);
    }
}

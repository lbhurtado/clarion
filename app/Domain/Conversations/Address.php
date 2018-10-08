<?php

namespace Clarion\Domain\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;

class Address extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->bot->reply('Address Conversation - work on it!');
    }
}

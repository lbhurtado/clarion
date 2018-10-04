<?php

namespace Clarion\Http\Middleware;

use Tymon\JWTAuth\JWTAuth;
use Clarion\Domain\Contracts\UserRepository;
use Clarion\Domain\Criteria\HasTheFollowing;
use Clarion\Domain\Models\Messenger;
use Clarion\Domain\Contracts\MessengerRepository;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Heard;
use BotMan\BotMan\Interfaces\Middleware\Sending;
use BotMan\BotMan\Interfaces\Middleware\Captured;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class ManagesUsersMiddleware implements Received, Matching
{
    /**
     * Handle an incoming message.
     *
     * @param IncomingMessage $message
     * @param BotMan $bot
     * @param $next
     *
     * @return mixed
     */
    public function received(IncomingMessage $message, $next, BotMan $bot)
    {
        $message->addExtras('token', $this->getToken($bot, $message));

        return $next($message);
    }

    /**
     * @param \BotMan\BotMan\Messages\Incoming\IncomingMessage $message
     * @param string $pattern
     * @param bool $regexMatched Indicator if the regular expression was matched too
     * @return bool
     */
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        // All messages only match, when not a new user.
        // This allows us to direct them through the
        // onboarding experience

        return $regexMatched && $message->getExtras('token') != null;
    }

    protected function getToken($bot, $message)
    {
        $token = ($user = $this->getUser($bot ,$message)) 
            ? app()->make(JWTAuth::class)->attempt(['mobile' => $user->mobile]) 
            : null;

        return $token;
    }

    protected function getUser($bot, $message)
    {
        $driver = $bot->getDriver()->getName();
        $chat_id = $message->getSender();

        // $chat_id = $bot->getUser()->getId();

        $messenger = app()->make(MessengerRepository::class)
            ->pushCriteria(HasTheFollowing::driver($driver))
            ->pushCriteria(HasTheFollowing::chat_id($chat_id))
            ->first();

        if ($messenger)
            return $messenger->user;
    }
}

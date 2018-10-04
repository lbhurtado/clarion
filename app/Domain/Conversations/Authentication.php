<?php

namespace Clarion\Domain\Conversations;

use Clarion\Domain\Jobs\VerifyOTP;
use Clarion\Domain\Events\UserWasFlagged;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

use Tymon\JWTAuth\JWTAuth;

class Authentication extends Conversation
{
	protected $user;

    public function run()
    {
    	$this->user = $this->getUser();

        if ($user = $this->user) {
	    	event(new UserWasFlagged($user));

        	$this->inputPIN();
        }
    }

    protected function inputPIN()
    {
        $question = Question::create(trans('authentication.input_pin'));

        $this->ask($question, function (Answer $answer) {
        	$otp = $answer->getText();
        	
        	VerifyOTP::dispatch($this->user, $otp);

        	sleep(2);
        	$this->authenticate();
        });
    }

    protected function authenticate()
    {
        $driver = $this->bot->getDriver()->getName();
        $chat_id = $this->bot->getUser()->getId();

    	$this->bot->reply(trans('authentication.authenticated', compact('driver', 'chat_id')));
    }

    protected function getUser()
    {
    	return app()->make(JWTAuth::class)->user();
    }
}

<?php

namespace Clarion\Domain\Conversations;

use Tymon\JWTAuth\JWTAuth;
use Clarion\Domain\Jobs\VerifyOTP;
use Clarion\Domain\Events\UserWasFlagged;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class Login extends Conversation
{
	protected $pin; //deprecate

    public function run()
    {
        event(new UserWasFlagged($this->getUser()));            

        $this->inputPIN(); 
    }

    protected function inputPIN()
    {
        $handle = ucfirst($this->getUser()->handle);
        $question = Question::create(trans('login.input_pin', compact('handle')))
                        ->addButtons([
                            Button::create(trans('login.button_break'))->value('/break'),
                        ]);
        $this->counter = 0;
        $this->ask($question, function (Answer $answer) {
            if (($answer->getText() == '') || ($answer->getText() == '/break') || ++$this->counter == 3)
                return $this->bot->reply(trans('login.break'));

            $otp = $answer->getText();
        	
        	VerifyOTP::dispatch($this->getUser(), $otp);
 
        	$this->authenticate();
        });
    }

    protected function authenticate()
    {

        $this->getUser()->refresh();

        if ($this->getUser()->isVerificationStale())
            return $this->inputPIN();

    	return $this->bot->reply(trans('login.authenticated'));
    }

    protected function getUser()
    {
    	return app()->make(JWTAuth::class)->user();
    }
}

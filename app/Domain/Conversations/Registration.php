<?php

namespace Clarion\Domain\Conversations;

use Tymon\JWTAuth\JWTAuth;
use Clarion\Domain\Models\User;
use Clarion\DOmain\Models\Mobile;
use Clarion\Domain\Jobs\VerifyOTP;
use Clarion\Domain\Events\UserWasFlagged;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;

class Registration extends Conversation
{
	protected $user;

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->inputMobile();
    }

    protected function inputMobile()
    {
        $question = Question::create(trans('authentication.input_mobile'));

        $this->ask($question, function (Answer $answer) {

	        try {
	              $mobile = Mobile::number($answer->getText());      
	        } catch (\Exception $e) {
	            return $this->repeat();
	        }
        	
        	if ($this->user = User::create(compact('mobile'))) {
       	 		$driver = $this->bot->getDriver()->getName();
        		$chat_id = $this->bot->getUser()->getId();
        		
        		$this->user->messengers()->create(compact('driver','chat_id'));

        		event(new UserWasFlagged($this->user));

        		$this->inputPIN();	
        	}
        	else return $this->repeat();
        });
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

        $this->bot->reply($this->user->mobile);

    	$this->bot->reply(trans('authentication.authenticated', compact('driver', 'chat_id')));
    }

    protected function getUser()
    {
    	return app()->make(JWTAuth::class)->user();
    }

}

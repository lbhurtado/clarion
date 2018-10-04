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

use Clarion\Domain\Models\Admin;
use Clarion\Domain\Criteria\HasTheFollowing;
use Clarion\Domain\Contracts\FlashRepository;

class Registration extends Conversation
{
	protected $user;

    protected $flash;

    protected $model;

    protected $user_id;

    protected $user_type;

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->inputCode();
    }

    protected function inputCode()
    {
        $question = Question::create(trans('authentication.input_code'));

        $this->ask($question, function (Answer $answer) {
            $flash = app()->make(FlashRepository::class)
                ->getByCriteria(HasTheFollowing::code($answer->getText()))
                ->first();

            $this->flash = $flash;

            // $this->user_id = $flash->user_id;
            // $this->model = app()->make($flash->getModel());
            
            $this->inputMobile();
        });
    }

    protected function inputMobile()
    {
        $question = Question::create(trans('authentication.input_mobile'));
        $this->ask($question, function (Answer $answer) {
	        try { 
                $mobile = Mobile::number($answer->getText());
            } 
            catch (\Exception $e) {
	            return $this->repeat(trans('authentication.input_repeat'));
	        }
            $driver = $this->bot->getDriver()->getName();
            $chat_id = $this->bot->getUser()->getId();
            if ($this->flash->user_id == null) {
                if ($this->user = ($this->flash->getModel())::create(compact('mobile'))) {

                    $this->user->messengers()->create(compact('driver','chat_id'));
                    event(new UserWasFlagged($this->user));


                }
            } else {
                $this->user = User::find($this->flash->user_id)->signsUp($this->flash->type, compact('mobile', 'driver', 'chat_id'));
            } 

            $this->inputPIN();  
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

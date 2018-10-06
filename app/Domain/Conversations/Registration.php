<?php

namespace Clarion\Domain\Conversations;

use Tymon\JWTAuth\JWTAuth;
use Clarion\Domain\Models\User;
use Clarion\DOmain\Models\Mobile;
use Clarion\Domain\Jobs\VerifyOTP;
use Clarion\Domain\Events\UserWasFlagged;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

use Illuminate\Support\Facades\Validator;
use Clarion\Domain\Models\Admin;
use Clarion\Domain\Criteria\HasTheFollowing;
use Clarion\Domain\Contracts\{UserRepository, MessengerRepository, FlashRepository};

class Registration extends Conversation
{
    protected $flash = null;

	protected $user;

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
        $question = Question::create(trans('authentication.input_code'))
                        ->addButtons([
                            Button::create(trans('authentication.button_break'))->value('/break'),
                        ]);
        $this->counter = 0;
        $this->ask($question, function (Answer $answer) {
            $this->flash = $this->getFlash($code = $answer->getText());
            if (($code == '') || ($code == '/break') || ++$this->counter == 3)
                return $this->bot->reply(trans('authentication.break'));
            if ($this->flash == null) {
                $this->bot->reply(trans('authentication.input_code_error'));
                return $this->repeat();
            }
            $this->inputMobile();
        });
    }

    protected function inputMobile()
    {
        $question = Question::create(trans('authentication.input_mobile'))
                        ->addButtons([
                            Button::create(trans('authentication.button_break'))->value('/break'),
                        ]);
        $this->counter = 0;
        $this->ask($question, function (Answer $answer) {
            if (($answer->getText() == '') || ($answer->getText() == '/break') || ++$this->counter == 3)
                return $this->bot->reply(trans('authentication.break'));
	   
            if (!$mobile = Mobile::validate($answer->getText())) {
                $this->bot->reply(trans('authentication.input_mobile_error'));
                return $this->repeat();                
            }

            $driver = $this->bot->getDriver()->getName();
            $chat_id = $this->bot->getUser()->getId();
            
            if ($this->uplineRegistered()) {
                if ($this->user = $this->getExistingUser($mobile))
                    $this->attachToUpline()->addMessenger($driver, $chat_id);
                else {
                    $credentials = compact('mobile', 'driver', 'chat_id');
                    $this->user = $this->getUpline()->signsUp($this->getUserType(), $credentials);
                } 
            } 
            else
                $this->user = $this->autoRegister($mobile, $driver, $chat_id); 

            event(new UserWasFlagged($this->user));            

            $this->inputPIN();  
        });
    }

    protected function inputPIN()
    {
        $question = Question::create(trans('authentication.input_pin'))
                        ->addButtons([
                            Button::create(trans('authentication.button_break'))->value('/break'),
                        ]);
        $this->counter = 0;
        $this->ask($question, function (Answer $answer) {
            if (($answer->getText() == '') || ($answer->getText() == '/break') || ++$this->counter == 3)
                return $this->bot->reply(trans('authentication.break'));

            $otp = $answer->getText();
        	
        	VerifyOTP::dispatch($this->user, $otp);
             
        	$this->authenticate();
        });
    }
    
    protected function authenticate()
    {
        $this->user->refresh();

        if (!$this->user->isVerified())
            return $this->inputPIN();

    	return $this->bot->reply(trans('authentication.authenticated', [
            'mobile' => $this->user->mobile,
            'driver' => $this->getDriver(),
        ]));
    }

    protected function getUser()
    {
    	return app()->make(JWTAuth::class)->user();
    }

    protected function uplineRegistered()
    {
        return $this->flash->user_id != null;
    }

    protected function autoRegister($mobile, $driver, $chat_id)
    {
        $model = $this->flash->getModel()::firstOrCreate(compact('mobile'));
        $model->messengers()->updateOrCreate(compact('driver'), compact('driver','chat_id'));

        return $model;
    }

    protected function getDriver()
    {
        return $this->bot->getDriver()->getName();
    }

    protected function getExistingUser($mobile)
    {
        return app()->make(UserRepository::class)
                    ->getByCriteria(HasTheFollowing::mobile($mobile))
                    ->first();
    }

    protected function getUpline()
    {
        return app()->make(UserRepository::class)->find($this->flash->user_id);
    }

    protected function attachToUpline()
    {
        $this->getUpline()->appendNode($this->user);

        return $this->user;
    }

    protected function getUserType()
    {
        return $this->flash->type;
    }

    protected function getFlash($code)
    {
        return app()->make(FlashRepository::class)
                    ->getByCriteria(HasTheFollowing::code($code))
                    ->first() ?? null;
    }
}

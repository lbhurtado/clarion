<?php

namespace Tests\BotMan;

use Tests\TestCase;
// use Clarion\Domain\Models\{Admin, Staff, Operator, Flash};
// use Clarion\Domain\Models\Mobile;
// use BotMan\Drivers\Telegram\TelegramDriver;
use Clarion\Domain\Contracts\UserRepository;
// use Clarion\Domain\Criteria\HasTheFollowing;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    function setUp()
    {
        parent::setUp();

        $this->users = $this->app->make(UserRepository::class);
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function bot_registration_requires_register_keyword()
    {
        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code'))             
            ->receivesInteractiveMessage('/break')
            ->assertReply(trans('registration.break')) 
            ;
    }

    /** @test */
    public function bot_registration_requires_registration_code()
    {
        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code')) 
            ->receives('not a valid code')
            ->assertReply(trans('registration.input_code_error')) 
            ->receives('537537')
            ->assertTemplate(Question::class)
            ;
    }

    /** @test */
    public function bot_registration_requires_valid_mobile()
    {
        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code')) 
            ->receives('537537')
            ->assertQuestion(trans('registration.input_mobile')) 
            ->receives('000000') //invalid mobile number
            ->assertReply(trans('registration.input_mobile_error')) 
            ->receives('09173011987')
            ->assertTemplate(Question::class)
            ;
    }

    /** @test */
    public function bot_registration_sends_otp_request()
    {
        \Queue::fake();
        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code')) 
            ->receives('537537')
            ->assertQuestion(trans('registration.input_mobile')) 
            ->receives('09173011987') 
            // ->assertQuestion(trans('registration.input_pin')) 
            ;

        \Queue::assertPushed(\Clarion\Domain\Jobs\RequestOTP::class);
    }

    /** @test */
    public function bot_registration_requires_valid_otp()
    {
        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code')) 
            ->receives('537537')
            ->assertQuestion(trans('registration.input_mobile')) 
            ->receives('09173011987') 
            ->assertQuestion(trans('registration.input_pin')) 
            ;
    }
}

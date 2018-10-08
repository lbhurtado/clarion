<?php

namespace Tests\BotMan;

use Tests\TestCase;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);

        $this->bot
            ->receives('/register')
            ->assertQuestion(trans('registration.input_code')) 
            ->receives('537537')
            ->assertQuestion(trans('registration.input_mobile')) 
            ->receives('09173011987') 
            ->assertQuestion(trans('registration.input_pin')) 
            ;
    }

    /** @test */
    public function bot_login_requires_login_keyword()
    {
        $this->bot
            ->receives('/login')
            ->assertQuestion(trans('login.input_pin'))             
            ->receivesInteractiveMessage('/break')
            ->assertReply(trans('login.break')) 
            ;
    }

    // /** @test */
    public function bot_login_requires_valid_user()
    {
        $this->bot
            ->receives('/login')
            ->assertQuestion(trans('registration.input_mobile')) 
            ->receives('000000') //invalid mobile number
            ->assertReply(trans('registration.input_mobile_error')) 
            ->receives('09173011987')
            ->assertTemplate(Question::class)
            ;
    }
}

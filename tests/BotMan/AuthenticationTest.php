<?php

namespace Tests\BotMan;

use Tests\TestCase;
use Clarion\Domain\Models\Admin;
use Clarion\Domain\Models\Mobile;
use BotMan\Drivers\Telegram\TelegramDriver;
use Clarion\Domain\Contracts\UserRepository;
use Clarion\Domain\Criteria\HasTheFollowing;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    function setUp()
    {
        parent::setUp();

        $this->users = $this->app->make(UserRepository::class);
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

    /** @test */
    public function bot_authenticates_via_mobile_and_otp()
    {
        \Queue::fake();

        $driver = config('clarion.default.admin.driver');
        $chat_id = config('clarion.default.admin.chat_id');
    
        $this->assertDatabaseHas('messengers', compact('driver', 'chat_id'));
//Web 1538619099368
        $this->bot
            ->setDriver(TelegramDriver::class)
            ->setUser(['id' => $chat_id])
            ->receives('/authenticate')
            ->assertTemplate(Question::class)
            ->receives('1234')
            ->assertReply(trans('authentication.authenticated', compact('driver', 'chat_id')))
            ;

        \Queue::assertPushed(\Clarion\Domain\Jobs\RequestOTP::class);
    }

    /** @test */
    public function bot_registers_mobile()
    {
        $driver = config('clarion.test.user1.driver');
        $chat_id = config('clarion.test.user1.chat_id');

        $this->bot
            ->setDriver(TelegramDriver::class)
            ->setUser(['id' => $chat_id])
            ->receives('/register')
            ->assertTemplate(Question::class)
            ->receives('09189362340')
            ->assertTemplate(Question::class)
            ->receives('1234')
            ->assertReply('+639189362340')
            ->assertReply(trans('authentication.authenticated', compact('driver', 'chat_id')))
            ;
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Clarion\Domain\Models\User;
use Clarion\Domain\Jobs as Jobs;
use Clarion\Domain\Events as Events;
use Illuminate\Foundation\Testing\WithFaker;
use Clarion\Domain\Listeners\Notify as Notify;
use Clarion\Domain\Listeners\Capture as Capture;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEventsTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function user_model_has_user_recorded_event()
    {
        $this->expectsEvents(Events\UserWasRecorded::class);

        $user = factory(User::class)->create(['mobile' => '9189362340']);
    }

    /** @test */
    function user_model_recorded_event_has_capture_user_mobile_data_listener()
    {
    	$listener = \Mockery::spy(Capture\UserMobileData::class);
    	app()->instance(Capture\UserMobileData::class, $listener);

        $user = factory(User::class)->create(['mobile' => '9189362340']);

        $listener->shouldHaveReceived('handle')->with(\Mockery::on(function($event) use ($user) {
            $this->assertInstanceOf(Events\UserWasRecorded::class, $event);
            return empty($event->user->authy_id);
        }))->once();  	

        $this->assertTrue(empty($user->authy_id));
    }

    /** @test */
    function user_model_capture_user_mobile_data_listener_pushes_registry_authy_service()
    {
        \Queue::fake();

        $user = factory(User::class)->create(['mobile' => '9189362340']);

        \Queue::assertPushed(Jobs\RegisterAuthyService::class);
    }

    /** @test */
    function user_model_has_user_registered_event()
    {
        $this->expectsEvents(Events\UserWasRegistered::class);

        $user = factory(User::class)->create(['mobile' => '9189362340']);
        $user->authy_id = '1234567';
        $user->save();
    }

    /** @test */
    function user_model_registered_event_has_notify_user_about_verification_listener()
    {
        $listener = \Mockery::spy(Notify\UserAboutVerification::class);
        app()->instance(Notify\UserAboutVerification::class, $listener);

        $user = factory(User::class)->create(['mobile' => '9173011987']);
        $user->authy_id = '1234567';
        $user->save();

        $listener->shouldHaveReceived('handle')->with(\Mockery::on(function($event) use ($user) {
            $this->assertInstanceOf(Events\UserWasRegistered::class, $event);
            return !empty($event->user->authy_id);
        }))->once();    
    }

    /** @test */
    function user_model_notify_user_about_verification_listener_pushes_request_otp()
    {
        \Queue::fake();

        $user = factory(User::class)->create(['mobile' => '9189362340']);
        $user->authy_id = '1234567';
        $user->save();
        
        \Queue::assertPushed(Jobs\RequestOTP::class);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Clarion\Domain\Models\User;
use Clarion\Domain\Contracts\UserRepository;
use Clarion\Domain\Criteria\HasTheFollowing;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
	use RefreshDatabase;
    
    function setUp()
    {
        parent::setUp();

        $this->users = $this->app->make(UserRepository::class);
    }

  	/** @test */
    public function user_can_be_registered_via_api_call()
    {
    	$mobile = config('clarion.test.user.mobile');

    	$credentials = config('clarion.test.user');

    	$response = $this->json('POST', '/api/auth/register', $credentials);

    	$attributes = collect($credentials)->pipe(function($collection) use ($mobile) {
    		$mobile = \Clarion\Domain\Models\Mobile::number($collection['mobile']);

    		return $collection->put('mobile', $mobile);
    	})->toArray();

		$response
			->assertStatus(201)
			->assertJsonFragment($attributes);

    	tap($this, function () {
    		return $this->users->pushCriteria(HasTheFollowing::mobile(config('clarion.test.user.mobile')));
    	})->assertEquals($this->users->all()->count(), 1);

    }

  	/** @test */
    public function user_can_be_logged_in_via_api_call()
    {
    	$mobile = config('clarion.test.user.mobile');

    	$user = factory(User::class)->create(compact('mobile'));

    	$response = $this->json('POST', '/api/auth/login', compact('mobile'))->assertSuccessful();

    	// dd($response->getData());
    	// dd($response->getData()->meta->token);

		$this->assertAuthenticatedAs($user);
    }
}

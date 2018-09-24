<?php

namespace Tests\Unit;

use Tests\TestCase;
use Clarion\Domain\Models\Admin;
use Clarion\Domain\Contracts\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
	use RefreshDatabase;

  	/** @test */
    function admin_model_is_essentially_a_user_with_a_type()
    {
	    $admin = factory(Admin::class)->create(['mobile' => '09189362340']);

  		$user = $this->app->make(UserRepository::class)->findByField('mobile', $admin->mobile)->first();

	    $this->assertEquals($user->id, $admin->id);
	    $this->assertEquals($user->type, Admin::class);
    }
}

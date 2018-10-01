<?php

namespace Tests\Feature;

use Tests\TestCase;
use Spatie\Permission\Models\{Role, Admin};
use Clarion\Domain\Contracts\UserRepository;
use Clarion\Domain\Criteria\HasTheFollowing;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckinTest extends TestCase
{
	use RefreshDatabase;

	protected $users;

    function setUp()
    {
        parent::setUp();

        $this->users = $this->app->make(UserRepository::class);
        $this->withoutEvents();
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);
    }

	 /** @test */
    function a_single_admin_role_is_seeded()
    {
		$this->assertEquals(Role::where('name', 'admin')->count(), 1);
    }

	 /** @test */
    function a_single_admin_user_is_seeded()
    {
    	$this->users
			->pushCriteria(HasTheFollowing::mobile(config('clarion.default.admin.mobile')))
    		->pushCriteria(HasTheFollowing::handle(config('clarion.default.admin.handle')));

		$this->assertEquals($this->users->all()->count(), 1);
    }
}

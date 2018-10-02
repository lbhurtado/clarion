<?php

namespace Tests\Feature;

use Tests\TestCase;
use Clarion\Domain\Models\{Admin, Operator, Staff, Worker, Subscriber};
use Spatie\Permission\Models\Role;
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

	 /** @test */
    function admin_user_checks_in_operator_staff_worker_subscriber()
    {
    	$admin = Admin::first();

    	$operator = $admin->signsUp('operator', config('clarion.test.user1'));
		$this->assertInstanceOf(Operator::class, $operator);
		$this->assertEquals($operator->parent_id, $admin->id);
		$this->assertTrue(! is_null($operator->verified_at));

    	$staff = $operator->signsUp('staff', config('clarion.test.user2'));
		$this->assertInstanceOf(Staff::class, $staff);
		$this->assertEquals($staff->parent_id, $operator->id);
		$this->assertTrue(! is_null($staff->verified_at));

		$worker = $operator->signsUp('worker', config('clarion.test.user3'));
		$this->assertInstanceOf(Worker::class, $worker);
		$this->assertEquals($worker->parent_id, $operator->id);
		$this->assertTrue(! is_null($worker->verified_at));

		$subscriber = $worker->signsUp('subscriber', config('clarion.test.user4'));
		$this->assertInstanceOf(Subscriber::class, $subscriber);
		$this->assertEquals($subscriber->parent_id, $worker->id);
		$this->assertTrue(! is_null($subscriber->verified_at));
    }
}

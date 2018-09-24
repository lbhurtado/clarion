<?php

namespace Tests\Unit;

use Tests\TestCase;
use Clarion\Domain\Models\Admin;
use Spatie\Permission\Models\Role;
use Clarion\Domain\Models\Operator;
use Clarion\Domain\Contracts\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParentModelsTest extends TestCase
{
	use RefreshDatabase;

    public function setUp()
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

  	/** @test */
    function admin_model_is_essentially_a_user_with_a_type()
    {
	    $admin = factory(Admin::class)->create(['mobile' => '09189362340']);

  		$user = $this->app->make(UserRepository::class)->findByField('mobile', $admin->mobile)->first();

	    $this->assertEquals($user->id, $admin->id);
	    $this->assertEquals($user->type, Admin::class);
    }

    /** @test */
    function admin_model_has_an_admin_role()
    {	
    	$admin = factory(Admin::class)->create(['mobile' => '09189362340']);

 		$this->assertDatabaseHas('roles', ['name' => 'admin']);
    	$this->assertTrue($admin->hasRole('admin'));    
    }

  	/** @test */
    function operator_model_is_essentially_a_user_with_a_type()
    {
	    $operator = factory(Operator::class)->create(['mobile' => '09189362340']);

  		$user = $this->app->make(UserRepository::class)->findByField('mobile', $operator->mobile)->first();

	    $this->assertEquals($user->id, $operator->id);
	    $this->assertEquals($user->type, Operator::class);
    }

  	/** @test */
    function operator_model_has_an_operator_role()
    {	
    	$operator = factory(Operator::class)->create(['mobile' => '09189362340']);

 		$this->assertDatabaseHas('roles', ['name' => 'operator']);
    	$this->assertTrue($operator->hasRole('operator'));    
    }

}

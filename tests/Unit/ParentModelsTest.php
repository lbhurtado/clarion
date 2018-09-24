<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Clarion\Domain\Models as Models;
use Clarion\Domain\Contracts\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParentModelsTest extends TestCase
{
	use RefreshDatabase;

	protected $children = [
		'09173011987' => Models\Admin::class,
		'09178951991' => Models\Operator::class,
		'09188362340' => Models\Staff::class,
		'09188362341' => Models\Subscriber::class,
		'09188362342' => Models\Worker::class,
	];

    public function setUp()
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    }

  	/** @test */
    function child_model_is_essentially_a_user_with_a_type()
    {
    	foreach ($this->children as $mobile => $class) {
		    $child = factory($class)->create(compact('mobile'));

	  		$user = $this->app->make(UserRepository::class)->findByField('mobile', $child->mobile)->first();

		    $this->assertEquals($user->id, $child->id);
		    $this->assertEquals($user->type, $class);
    	}
    }

    /** @test */
    function child_model_has_a_child_role()
    {	
    	foreach ($this->children as $mobile => $class) {
		    $child = factory($class)->create(compact('mobile'));

 			$this->assertDatabaseHas('roles', [
 				'name' 		 => $child::$role, 
 				'guard_name' => $child->getGuardName()
 			]);

    		$this->assertTrue($child->hasRole($child::$role)); 
    	}
    }
}

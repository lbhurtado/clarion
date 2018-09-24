<?php

namespace Tests\Unit;

use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolesAndPermissionsTest extends TestCase
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
    function roles_can_be_persisted()
    {
    	$role = Role::create(['name' => 'writer']);

    	$this->assertDatabaseHas('roles', ['name' => 'writer']);
    }

    /** @test */
    function permissions_can_be_persisted()
    {
    	$permission = Permission::create(['name' => 'edit articles']);

    	$this->assertDatabaseHas('permissions', ['name' => 'edit articles']);
    }
 
  	/** @test */
    function roles_can_be_assigned_permissions()
    {
    	$role = Role::create(['name' => 'writer']);
		$permission1 = Permission::create(['name' => 'edit articles']);
		$permission2 = Permission::create(['name' => 'delete articles']);

		$role->givePermissionTo('edit articles');
		$role->givePermissionTo($permission2);

		$this->assertTrue($role->hasPermissionTo($permission1));
		$this->assertTrue($role->hasPermissionTo('delete articles'));
    }   

    /** @test */
    function roles_and_permissions_can_be_seeded()
    {
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);

        $this->assertEquals(Role::all()->count(), 3);
        $this->assertEquals(Permission::all()->count(), 4);

        $this->assertEquals(Role::where('name', 'writer')->count(), 1);
    } 
}

<?php

use Illuminate\Database\Seeder;
use Clarion\Domain\Models\{User, Flash};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClarionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		app()['cache']->forget('spatie.permission.cache');

    	// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	Schema::disableForeignKeyConstraints();
		DB::table('flashes')->truncate();
    	DB::table('users')->truncate();
    	DB::table('roles')->truncate();
    	DB::table('permissions')->truncate();

    	$attributes = config('clarion.seed.permissions');

       	foreach ($attributes as $attribute) {
       		Permission::create($attribute);
        } 

    	$attributes = config('clarion.seed.roles');
       	foreach ($attributes as $attribute) {
	    	$permissions = array_pull($attribute, 'permissions');
       		$role = Role::create($attribute);
       		if ($permissions) foreach ($permissions as $permission)
       			$role->givePermissionTo($permission);
        }    	 

        $credentials = config('clarion.seed.users');

        foreach ($credentials as $credential) {
            $type = array_pull($credential, 'type');
            factory($type)->create($credential);
        }

        $attributes = config('clarion.seed.flashes');

        foreach ($attributes as $attribute) {
            $handle = array_pull($attribute, 'handle');
            $flash = Flash::create($attribute);
            if ($handle && $user = User::where(compact('handle'))->first())
            	$flash->user()->associate($user)->save();
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::enableForeignKeyConstraints();
    }
}

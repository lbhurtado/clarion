<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'check in others']);
        Permission::create(['name' => 'invite others']);
        Permission::create(['name' => 'send messages upwards']);
        Permission::create(['name' => 'send messages sideways']);
        Permission::create(['name' => 'send messages downwards']);
        Permission::create(['name' => 'vet others']);

        Role::create(['name' => 'subscriber'])
            ->givePermissionTo('check in others');

        Role::create(['name' => 'worker'])
            ->givePermissionTo('check in others');

        Role::create(['name' => 'staff'])
            ->givePermissionTo('check in others');

        Role::create(['name' => 'operator'])
            ->givePermissionTo('check in others');

        Role::create(['name' => 'admin'])
            ->givePermissionTo(Permission::all());
    }
}

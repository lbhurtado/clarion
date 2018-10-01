<?php

use Illuminate\Database\Seeder;
use Clarion\Domain\Models\Admin;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class)->create([
        	'mobile' => config('clarion.default.admin.mobile'), 
        	'handle' => config('clarion.default.admin.handle')
        ]);
    }
}

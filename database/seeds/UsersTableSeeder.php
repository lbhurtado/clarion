<?php

use Illuminate\Database\Seeder;
use Clarion\Domain\Models\{Admin, Messenger};

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
        	'handle' => config('clarion.default.admin.handle'),
        ])
            ->messengers()
            ->save(factory(Messenger::class)->create([
                'driver' => config('clarion.default.admin.driver'), 
                'chat_id' => config('clarion.default.admin.chat_id'),
            ])
        );
    }
}

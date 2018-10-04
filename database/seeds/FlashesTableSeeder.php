<?php

use Illuminate\Database\Seeder;
use Clarion\Domain\Models\Admin;

class FlashesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flashes')->truncate();

        $flashes = [
            ['code' => '537537', 'type' => 'admin', 'user_id' => null],
            ['code' => '111111', 'type' => 'staff', 'user_id' => Admin::first()->id],
            ['code' => '222222', 'type' => 'operator', 'user_id' => Admin::first()->id],
        ];

        DB::table('flashes')->insert($flashes);
    }
}

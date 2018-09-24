<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMessengersTable.
 */
class CreateMessengersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messengers', function(Blueprint $table) {
            $table->increments('id');
            $table->string('identifier');
            $table->string('driver');
            $table->string('chat_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamps();
            
            $table->unique(['driver', 'chat_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messengers');
	}
}

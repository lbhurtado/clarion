<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFlashesTable.
 */
class CreateFlashesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flashes', function(Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type');
			$table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->unique(['type', 'user_id']);
           	$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flashes');
	}
}

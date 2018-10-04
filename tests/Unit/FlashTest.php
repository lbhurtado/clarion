<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Clarion\Domain\Models\User;
use Clarion\Domain\Models\Flash;
use Clarion\Domain\Criteria\HasTheFollowing;
use Clarion\Domain\Contracts\FlashRepository;

class FlashTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function flash_model_has_code_type()
    {
        $flash = Flash::create([
        	'code' => '123456',
        	'type' => 'admin',
        ]);

        $this->assertDatabaseHas('flashes', [
        	'code' => '123456',
        	'type' => 'admin',
        ]);

    }

    /** @test */
    public function flash_model_has_user_id()
    {
    	$flash = $this->app->make(FlashRepository::class)->create([
    		'code' => '123456',
        	'type' => 'admin',
    	]);

    	$flash->user()
    		->associate($user = factory(User::class)->create(array_only(config('clarion.test.user'), ['mobile'])))
    		->save();

    	$this->assertDatabaseHas('flashes', [
        	'user_id' => $user->id
        ]);
    }

    /** @test */
    public function flash_model_can_be_looked_up()
    {
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);

    	$code = '537537';

    	$flashes = $this->app->make(FlashRepository::class);

    	$flash = $flashes->getByCriteria(HasTheFollowing::code($code))->first();

    	$this->assertInstanceOf(User::class, $this->app->make($flash->getModel()));
    }
}

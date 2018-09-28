<?php

namespace Tests\Unit;

use Tests\TestCase;
use Clarion\Domain\Models\User;
use Clarion\Domain\Models\Messenger;
use Clarion\Domain\Contracts\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Clarion\Domain\Criteria\HasTheFollowing;
use Clarion\Domain\Criteria\EagerLoad;
use Clarion\Domain\Contracts\MessengerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessengerTest extends TestCase
{
	use RefreshDatabase;

    function setUp()
    {
        parent::setUp();

        $this->withoutEvents();
    }
    
  	/** @test */
    function messenger_model_has_required_driver_field()
    {
    	$this->expectException(\Prettus\Validator\Exceptions\ValidatorException::class);

        $this->app->make(MessengerRepository::class)->create([
        	'driver'  => 'asdsadsa',
        	'chat_id' => null
        ]);
    }

  	/** @test */
    function messenger_model_has_required_chat_id_field()
    {
    	$this->expectException(\Illuminate\Database\QueryException::class);
        Messenger::create([
        	'driver'  => null,
        	'chat_id' => 'sdasd'
        ]);
    }

  	/** @test */
    function messenger_model_has_unique_driver_and_chat_id_fields()
    {
    	$this->expectException(\Illuminate\Database\QueryException::class);
        
        Messenger::create([
        	'driver'  => 'Telegram',
        	'chat_id' => 'lbhurtado'
        ]);

        Messenger::create([
        	'driver'  => 'Telegram',
        	'chat_id' => 'lbhurtado'
        ]);
    }

  	/** @test */
    function messenger_model_belongs_to_a_user()
    {
    	$user = factory(User::class)->create(['mobile' => '09189362340', 'handle' => 'Lester']);

    	$messenger = $user->messengers()->create([
	        'driver'  => 'Telegram',
        	'chat_id' => 'lester'
    	]);

    	$this->assertDatabaseHas('messengers', [
    		'identifier' => $user->identifier,
    	]);

        $this->assertEquals($user->identifier, $messenger->identifier);
      
        $identifier = $user->messengers
        	->where('chat_id', 'lester')
        	->where('driver', 'Telegram')
        	->first()->identifier;

    	$this->assertEquals($user->identifier, $identifier);
    }

  	/** @test */
    function messenger_model_has_eager_load_user()
    {
    	if (\DB::connection()->getDriverName() != 'mysql') {
    		return $this->assertTrue(true);
    	}
        $users = $this->app->make(UserRepository::class);

    	$user1 = factory(User::class)->create(['mobile' => '09189362340', 'handle' => 'Lester']);
    	$user2 = factory(User::class)->create(['mobile' => '09173011987', 'handle' => 'Retsel']);

    	$this->assertEquals($users->all()->count(), 2);

        $user1->messengers()->create([
            'driver'  => 'Viber',
            'chat_id' => 'lbhurtado'
         ]);

    	$user2->messengers()->create([
    		'driver'  => 'Facebook',
    	 	'chat_id' => 'lester.hurtado'
    	 ]);

    	$user2->messengers()->create([
    		'driver'  => 'Telegram',
    	 	'chat_id' => 'lbhurtado'
    	 ]);

    	$user2->messengers()->create([
    		'driver'  => 'WhatsApp',
    	 	'chat_id' => 'lbhurtado'
    	 ]);

    	$this->assertEquals($users->all()->count(), 2);

        $users->pushCriteria(EagerLoad::messengers());

        $this->assertEquals($users->all()->count(), 4);

        $users->pushCriteria(HasTheFollowing::handle('Lester'));

        $this->assertEquals($users->all()->count(), 1);
    }
}

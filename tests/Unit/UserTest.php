<?php

namespace Tests\Unit;

use Tests\TestCase;
use Clarion\Domain\Models\User;
use Clarion\Domain\Models\Mobile;
use Clarion\Domain\Contracts\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
	use RefreshDatabase;

  	/** @test */
    function user_model_has_required_mobile_field()
    {
    	$this->expectException(\libphonenumber\NumberParseException::class);

        $user = User::create(['mobile' => null]);
    }

  	/** @test */
    function user_model_has_mobile_and_handle_fields()
    {
        $user = factory(User::class)->create(['mobile' => '09189362340', 'handle' => 'Lester']);

        $this->assertEquals(Mobile::number('09189362340'), $user->mobile);
        $this->assertEquals('Lester', $user->handle);
    }

    /** @test */
    function user_model_mobile_field_is_default_handle_value()
    {
    	$number = '09189362340';

        $user = $this->app->make(UserRepository::class)->create([
            'mobile' => $number,
        ]);

        $this->assertEquals(Mobile::number($number), $user->mobile);
        $this->assertEquals(Mobile::number($number), $user->handle);
    }

    /** @test */
    function user_model_has_unique_mobile_field()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        factory(User::class)->create(['mobile' => '09189362340']);
        factory(User::class)->create(['mobile' => '09189362340']);
    }

    /** @test */
    function user_model_only_accepts_ph_mobile_number()
    {
        $this->expectException(\Propaganistas\LaravelPhone\Exceptions\NumberParseException::class);

    	factory(User::class)->create(['mobile' => '+1 (301) 1234-567']);
    }

}

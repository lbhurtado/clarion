<?php

namespace Tests\Feature;

use Tests\TestCase;
use Clarion\Domain\Models\Mobile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhoneNumberTest extends TestCase
{
    /** @test */
    public function language_has_phone_validation()
    {
    	$this->assertEquals(trans('validation.phone'), 'The :attribute field contains an invalid number.');
    }

    /** @test */
    public function phone_number_is_formatted_correctly()
    {  
    	$phone = phone('639173011987', 'PH');
    	$this->assertEquals($phone->formatForMobileDialingInCountry('PH'), '09173011987');

    	$phone = phone('639173011987', 'PH');
    	$this->assertEquals($phone->formatE164(), '+639173011987');

    	$phone = phone('09173011987', 'PH');
    	$this->assertEquals($phone->formatE164(), '+639173011987');

    	$phone = phone('9173011987', 'PH');
    	$this->assertEquals($phone->formatE164(), '+639173011987');
    	$this->assertEquals($phone->getType(), 'mobile');

    	$phone = phone('+6329525603', 'PH');
    	$this->assertEquals($phone->getType(), 'fixed_line');

    	$phone = phone('6329525603', 'PH');
    	$this->assertEquals($phone->getType(), 'fixed_line');

    	$phone = phone('029525603', 'PH');
    	$this->assertEquals($phone->getType(), 'fixed_line');

    	$phone = phone('29525603', 'PH');
    	$this->assertEquals($phone->getType(), 'fixed_line');
    }

    /** @test */
    public function phone_number_is_validated_correctly()
    {
    	$rules = [
            'field1' => 'phone:PH,mobile'
        ];

    	$data = [
            'field1' => '+63 (918) 936-2340',
          	'field1' => '+639189362340',
            'field1' => '639189362340',
            'field1' => '(0918) 936-2340',
            'field1' => '09189362340',
            'field1' => '918-936-2340',
            'field1' => '9189362340',
        ];

    	$v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());

    	$data = [
        	'field1' => '+13026454233',
        	'field1' => '3026454233',
        	'field1' => '+6326454233',
        	'field1' => '6326454233',
           	'field1' => '026454233',
            'field1' => '26454233',
            'field1' => '6454233',
        ];

    	$v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->fails());
    }

    /** @test */
    public function phone_number_has_components()
    {
        $phone = phone('639173011987', 'PH');
        $this->assertEquals(Mobile::prefix($phone), '917');

        $this->assertEquals(Mobile::authy($phone), [
            'code' => '63',
            'number' => '9173011987'
        ]);
    }
}

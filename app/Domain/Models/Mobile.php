<?php

namespace Clarion\Domain\Models;

use Propaganistas\LaravelPhone\PhoneNumber;

class Mobile
{
	protected $mobile;

    /**
     * Mobile constructor.
     * @param $number
     */
    public function __construct($number, $country = 'PH')
    {
    	$this->mobile = PhoneNumber::make($number, $country);
    }

    public static function number($number, $country = 'PH')
    {
    	return (new static($number, $country))->mobile->formatE164();
    }

    public static function national($number, $country = 'PH')
    {
        return (new static($number, $country))->mobile->formatForMobileDialingInCountry('PH');
    }

    public static function prefix($number, $country = 'PH')
    {
    	
		return preg_split("/[\s,]+/", (new static($number, $country))->mobile->formatInternational('PH'))[1];
    }
}

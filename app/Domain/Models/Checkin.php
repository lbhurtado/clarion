<?php

namespace Clarion\Domain\Models;

class Checkin
{
	
	static public $mappings = [
    		'staff' => 'Clarion\Domain\Models\Staff',
    		'worker' => 'Clarion\Domain\Models\Worker',
    		'operator' => 'Clarion\Domain\Models\Operator',
    		'subscriber' => 'Clarion\Domain\Models\Subscriber',
    	];

	protected $object;
    
    protected $attributes;

    protected $class;

    static public function __callStatic($class, $attributes) {

        return new static($class, $attributes);
    }

    public function __construct($class, $attributes)
    {
    	$this->class = self::$mappings[$class];
    	$this->attributes = $attributes[0];
    }

    public function getUser()
    {
    	$user = app()->make($this->class)::create($this->attributes);

    	$user->messengers()->create($this->attributes);

    	return $user;
    }
}

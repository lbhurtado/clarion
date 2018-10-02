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
    
    protected $parent;

    protected $class;

    protected $attributes;

    protected $user;

    static public function __callStatic($class, $attributes) {

        return new static($class, $attributes);
    }

    public function __construct($class, $attributes)
    {
    	$this->class = self::$mappings[$class];
    	$this->attributes = $attributes[0];

    }

    public function setParentNodeOver($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function createUserAndAttachAsNodeOver()
    {
    	$this->user = app()->make($this->class)::create($this->attributes, $this->parent);

    	$this->user->messengers()->create($this->attributes);

    	return $this;
    }

    public function verifyUserOut()
    {
        $this->user->verified_at = now();

        $this->user->save();

        return $this->user;
    }
}

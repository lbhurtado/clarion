<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\HasParentModel;

class Subscriber extends User
{
	use HasParentModel;

	public static $role = 'subscriber';

	protected $guard_name = 'web';

}

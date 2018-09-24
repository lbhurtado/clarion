<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\HasParentModel;

class Worker extends User
{
	use HasParentModel;

	public static $role = 'worker';

	protected $guard_name = 'hq';

}

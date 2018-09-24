<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\HasParentModel;

class Operator extends User
{
	use HasParentModel;

	public static $role = 'operator';

	protected $guard_name = 'hq';

}

<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\HasParentModel;

class Staff extends User
{
	use HasParentModel;

	public static $role = 'staff';

	protected $guard_name = 'hq';

}

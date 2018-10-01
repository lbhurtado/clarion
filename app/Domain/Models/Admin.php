<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\HasParentModel;

class Admin extends User
{
	use HasParentModel;

	public static $role = 'admin';
}

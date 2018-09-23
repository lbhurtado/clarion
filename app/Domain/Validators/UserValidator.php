<?php

namespace Clarion\Domain\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace Clarion\Domain\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'required|phone:PH'	=>'	mobile=>required|phone:PH',
		''	=>'	mobile',
	],
        ValidatorInterface::RULE_UPDATE => [
		'required|phone:PH'	=>'	mobile=>required|phone:PH',
		''	=>'	mobile',
	],
    ];
}

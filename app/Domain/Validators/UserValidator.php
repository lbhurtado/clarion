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
            'mobile' => 'required|phone:PH',
            'handle' => 'min:1',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'mobile' => 'required|phone:PH',
            'handle' => 'min:1',
        ],
    ];
}

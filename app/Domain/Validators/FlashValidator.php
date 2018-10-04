<?php

namespace Clarion\Domain\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class FlashValidator.
 *
 * @package namespace Clarion\Domain\Validators;
 */
class FlashValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'code' => 'required',
            'type' => 'required',
	],
        ValidatorInterface::RULE_UPDATE => [
            'code' => 'required',
            'type' => 'required',
        ],
    ];
}

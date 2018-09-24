<?php

namespace Clarion\Domain\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MessengerValidator.
 *
 * @package namespace Clarion\Domain\Validators;
 */
class MessengerValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'driver'  => 'required',
            'chat_id' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'driver'  => 'required',
            'chat_id' => 'required',
        ],
    ];
}

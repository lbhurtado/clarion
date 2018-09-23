<?php

namespace Clarion\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Clarion\Domain\Models\User;

/**
 * Class UserTransformer.
 *
 * @package namespace Clarion\Http\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \Clarion\Domain\Models\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

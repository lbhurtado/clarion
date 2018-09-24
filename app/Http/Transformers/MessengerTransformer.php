<?php

namespace Clarion\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Clarion\Domain\Models\Messenger;

/**
 * Class MessengerTransformer.
 *
 * @package namespace Clarion\Http\Transformers;
 */
class MessengerTransformer extends TransformerAbstract
{
    /**
     * Transform the Messenger entity.
     *
     * @param \Clarion\Domain\Models\Messenger $model
     *
     * @return array
     */
    public function transform(Messenger $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

<?php

namespace Clarion\Http\Transformers;

use League\Fractal\TransformerAbstract;
use Clarion\Domain\Models\Flash;

/**
 * Class FlashTransformer.
 *
 * @package namespace Clarion\Http\Transformers;
 */
class FlashTransformer extends TransformerAbstract
{
    /**
     * Transform the Flash entity.
     *
     * @param \Clarion\Domain\Models\Flash $model
     *
     * @return array
     */
    public function transform(Flash $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

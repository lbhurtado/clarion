<?php

namespace Clarion\Http\Presenters;

use Clarion\Http\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace Clarion\Http\Presenters;
 */
class UserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }
}

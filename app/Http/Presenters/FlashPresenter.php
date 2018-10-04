<?php

namespace Clarion\Http\Presenters;

use Clarion\Http\Transformers\FlashTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlashPresenter.
 *
 * @package namespace Clarion\Http\Presenters;
 */
class FlashPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlashTransformer();
    }
}

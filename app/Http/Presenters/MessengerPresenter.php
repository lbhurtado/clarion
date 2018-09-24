<?php

namespace Clarion\Http\Presenters;

use Clarion\Http\Transformers\MessengerTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MessengerPresenter.
 *
 * @package namespace Clarion\Http\Presenters;
 */
class MessengerPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MessengerTransformer();
    }
}

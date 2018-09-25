<?php

namespace Clarion\Domain\Criteria;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class HasMessengerCriteria.
 *
 * @package namespace Clarion\Domain\Criteria;
 */
class EagerLoad implements CriteriaInterface
{

    public static function messengers()
    {
        return new static();
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->join('messengers', function($join) {
            $join->on('messengers.identifier', '=', DB::raw($this->getSqlAlgorithm()));
        });
    }

    protected function getSqlAlgorithm()
    {
        $sqlAlgorithm = "sha2(concat(users.mobile, '?'),256)";

        return  str_replace('?', config('app.key'), $sqlAlgorithm);
    }
}

<?php

namespace Clarion\Infrastructure\EloquentRepositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Clarion\Domain\Contracts\FlashRepository;
use Clarion\Domain\Models\Flash;
use Clarion\Domain\Validators\FlashValidator;

/**
 * Class FlashRepositoryEloquent.
 *
 * @package namespace Clarion\Infrastructure\EloquentRepositories;
 */
class FlashRepositoryEloquent extends BaseRepository implements FlashRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Flash::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlashValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

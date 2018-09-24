<?php

namespace Clarion\Infrastructure\EloquentRepositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Clarion\Domain\Contracts\MessengerRepository;
use Clarion\Domain\Models\Messenger;
use Clarion\Domain\Validators\MessengerValidator;

/**
 * Class MessengerRepositoryEloquent.
 *
 * @package namespace Clarion\Infrastructure\EloquentRepositories;
 */
class MessengerRepositoryEloquent extends BaseRepository implements MessengerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Messenger::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MessengerValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

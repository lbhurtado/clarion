<?php

namespace Clarion\Infrastructure\EloquentRepositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Clarion\Domain\Contracts\UserRepository;
use Clarion\Domain\Models\User;
use Clarion\Domain\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Clarion\Infrastructure\EloquentRepositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

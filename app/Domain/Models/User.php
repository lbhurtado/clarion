<?php

namespace Clarion\Domain\Models;

use Clarion\Domain\Traits\IsAnonymous;
use Clarion\Domain\Traits\HasMobile;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\ReturnsChildModels;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @package namespace Clarion\Domain\Models;
 */
class User extends Model implements Transformable
{
    use TransformableTrait, HasMobile, ReturnsChildModels, HasRoles, IsAnonymous;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'mobile',
		'handle',
	];

    public function messengers()
    {
        return $this->hasMany(Messenger::class, 'identifier', 'identifier');
    }
}

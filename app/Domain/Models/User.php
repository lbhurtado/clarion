<?php

namespace Clarion\Domain\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\ReturnsChildModels;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Clarion\Domain\Traits\{HasMobile, IsAnonymous, HasAuthy};
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @package namespace Clarion\Domain\Models;
 */
class User extends Authenticatable implements JWTSubject, Transformable
{
    use TransformableTrait, ReturnsChildModels, HasRoles, IsAnonymous, HasMobile, HasAuthy;

    const DEFAULT_PIN = '1234';

    public $username = 'mobile';

    protected $guard_name = 'web';

    protected $fieldSearchable = [
        'mobile',
        'handle',
        'authy_id'
    ];

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}

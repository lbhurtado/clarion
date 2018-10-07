<?php

namespace Clarion\Domain\Models;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tightenco\Parental\ReturnsChildModels;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Clarion\Domain\Traits\{HasMobile, IsAnonymous, HasAuthy, HasToken};
use Carbon\Carbon;

/**
 * Class User.
 *
 * @package namespace Clarion\Domain\Models;
 */
class User extends Authenticatable implements JWTSubject, Transformable
{
    use TransformableTrait, ReturnsChildModels, HasRoles, IsAnonymous, HasMobile, HasAuthy, HasToken;

    use NodeTrait;

    public $username = 'mobile';

    protected $guard_name = 'api';

    protected $fieldSearchable = [
        'mobile',
        'handle',
        'authy_id'
    ];

    protected $fillable = [
		'mobile',
		'handle',
	];

    protected $dates = [
        'verified_at', 
        'created_at', 
        'updated_at'
    ];

    public function messengers()
    {
        return $this->hasMany(Messenger::class);
    }

    public function signsUp($class, $attributes)
    {
        return Checkin::$class($attributes)
            ->setParentNodeOver($this)
            ->createUserAndAttachAsNodeOver()
            ->verifyUserOut();
    }

    public function addMessenger($driver, $chat_id)
    {
        $this->messengers()
            ->updateOrCreate(compact('driver'), compact('driver','chat_id'));

        return $this;
    }

    public function isVerified()
    {
        if ($this->verified_at && $this->verified_at <= Carbon::now()) {        
            return true;
        } else {
            return false;
        }
    }
}

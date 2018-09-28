<?php

namespace Clarion\Domain\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Tightenco\Parental\ReturnsChildModels;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Clarion\Domain\Traits\{HasMobile, IsAnonymous, HasAuthy};

/**
 * Class User.
 *
 * @package namespace Clarion\Domain\Models;
 */
class User extends Model implements Transformable
{
    use TransformableTrait, ReturnsChildModels, HasRoles, IsAnonymous, HasMobile, HasAuthy;

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
}

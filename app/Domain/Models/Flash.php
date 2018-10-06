<?php

namespace Clarion\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Flash.
 *
 * @package namespace Clarion\Domain\Models;
 */
class Flash extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'code',
		'type',
	];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getModel()
    {
        $value = $this->type;

        return (config("clarion.types.$value"));
    }

}
